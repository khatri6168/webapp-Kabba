<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Facades\Assets;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Enums\DeliveryStatusEnum;
use Botble\Ecommerce\Enums\DeliveryTypeEnum;
use Botble\Ecommerce\Enums\OrderStatusEnum;
use Botble\Ecommerce\Models\DeliveryNote;
use Botble\Ecommerce\Forms\DeliveryPickUpForm;
use Botble\Ecommerce\Http\Requests\DeliveryPickUpRequest;
use Botble\Ecommerce\Repositories\Interfaces\DeliveryPickUpInterface;
use Botble\Ecommerce\Tables\DeliveryPickUpTable;
use Botble\Payment\Enums\PaymentStatusEnum;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;


class DeliveryPickUpController extends BaseController
{
    public function __construct(protected DeliveryPickUpInterface $deliveryRepository)
    {
    }

    public function index(DeliveryPickUpTable $dataTable)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::deliveries.menu'));

        Assets::addStylesDirectly('vendor/core/core/base/libraries/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        Assets::addScriptsDirectly('vendor/core/core/base/libraries/bootstrap-datepicker/js/bootstrap-datepicker.min.js');

        Assets::addStylesDirectly('vendor/core/plugins/ecommerce/css/delivery.css');
        Assets::addScriptsDirectly('vendor/core/plugins/ecommerce/js/delivery.js');

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::deliveries.create'));

        return $formBuilder->create(DeliveryPickupForm::class)->renderForm();
    }

    public function store(DeliveryPickupForm $request, BaseHttpResponse $response)
    {
        $delivery = $this->deliveryRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(EMPLOYEE_MODULE_SCREEN_NAME, $request, $delivery));

        return $response
            ->setPreviousUrl(route('deliveries.index'))
            ->setNextUrl(route('deliveries.edit', $delivery->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int|string $id, FormBuilder $formBuilder)
    {
        $delivery = $this->deliveryRepository->findOrFail($id);

        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $delivery->product->name]));
        Assets::addStylesDirectly(['vendor/core/plugins/ecommerce/css/ecommerce.css'])
            ->addScripts(['timepicker', 'input-mask', 'blockui'])
            ->addStyles(['timepicker']);
        Assets::addScriptsDirectly('vendor/core/plugins/ecommerce/js/order.js');
        Assets::addScriptsDirectly('vendor/core/plugins/ecommerce/js/delivery_edit.js');
        Assets::addStylesDirectly('vendor/core/plugins/ecommerce/css/delivery_edit.css');

        $delivery->delivery_date = date("M d, Y", strtotime($delivery->delivery_date));
        $delivery->pickup_date = date("M d, Y", strtotime($delivery->pickup_date));

        $order = $delivery->order;

        $readonly = false;
//        return $formBuilder->create(DeliveryPickupForm::class, ['model' => $delivery])->renderForm();
        return view('plugins/ecommerce::deliveries.edit', compact('delivery', 'order', 'readonly'));
    }

    public function update(int|string $id, DeliveryPickUpRequest $request, BaseHttpResponse $response)
    {
        $delivery = $this->deliveryRepository->findOrFail($id);

        $delivery->fill($request->input());

        $delivery['delivery_date'] = date("Y-m-d", strtotime($delivery['delivery_date']));
        $delivery['pickup_date'] = date("Y-m-d", strtotime($delivery['pickup_date']));

        $updatedDelivery = $this->deliveryRepository->createOrUpdate($delivery);

/*        if ($updatedDelivery->id && isset($inputData['temp_notes'])) {
            //echo $updatedContact->id;die;
            DB::table('ec_delivery_notes')->where('delivery_id', $updatedDelivery->id)->delete();

            $notes = explode(',',$inputData['temp_notes']);
            if ($notes) {
                foreach ($notes as $note) {
                    $deliveryNote = new DeliveryNote();
                    $deliveryNote->notes = $note;
                    $deliveryNote->delivery_id = $updatedDelivery->id;
                    $deliveryNote->save();
                }
            }
        }*/

        event(new UpdatedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $delivery));

        return $response
            ->setPreviousUrl(route('deliveries.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function updateComment(int|string $id, Request $request, BaseHttpResponse $response)
    {
        $delivery = $this->deliveryRepository->findOrFail($id);
        $inputData = $request->input();

        $delivery->comment = $inputData['comment'];

        $this->deliveryRepository->createOrUpdate($delivery);

        event(new UpdatedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $delivery));

        return $response
            ->setPreviousUrl(route('deliveries.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function updateStatus(Request $request, BaseHttpResponse $response)
    {
        $id = $request->input('id');
        $delivery = $this->deliveryRepository->findOrFail($id);
        $inputData = $request->input();

        if ($inputData['action_name'] == 'save_and_edit') {
            $delivery->fill($request->input());
            $delivery['delivery_date'] = date("Y-m-d", strtotime($delivery['delivery_date']));
            $delivery['pickup_date'] = date("Y-m-d", strtotime($delivery['pickup_date']));
        } else {
            // save from calendar
            if ($inputData['type'] == DeliveryTypeEnum::DELIVERY || $inputData['type'] == DeliveryTypeEnum::CUSTOMER_DELIVERY) {
                $delivery->delivery_status = $inputData['status'];
            } else {
                $delivery->pickup_status = $inputData['status'];
            }
        }

        $this->deliveryRepository->createOrUpdate($delivery);

        event(new UpdatedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $delivery));

        return $response
            ->setPreviousUrl(route('deliveries.calendar'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function updateStatusById(int|string $id, Request $request, BaseHttpResponse $response)
    {
        $delivery = $this->deliveryRepository->findOrFail($id);
        $inputData = $request->input();

        if ($inputData['type'] == DeliveryTypeEnum::DELIVERY) {
            $delivery->delivery_status = $inputData['status'];
        } else {
            $delivery->pickup_status = $inputData['status'];
        }

        $this->deliveryRepository->createOrUpdate($delivery);

        event(new UpdatedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $delivery));

        return $response
            ->setPreviousUrl(route('deliveries.calendar'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(int|string $id, Request $request, BaseHttpResponse $response)
    {
        try {
            $delivery = $this->deliveryRepository->findOrFail($id);
            $this->deliveryRepository->delete($delivery);

            event(new DeletedContentEvent(EMPLOYEE_MODULE_SCREEN_NAME, $request, $delivery));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $delivery = $this->deliveryRepository->findOrFail($id);
            $this->deliveryRepository->delete($delivery);
            event(new DeletedContentEvent(EMPLOYEE_MODULE_SCREEN_NAME, $request, $delivery));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function calendar(Request $request)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::deliveries.calendar'));

        Assets::addStylesDirectly('https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css');
        Assets::addScriptsDirectly('https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js');
        Assets::addScriptsDirectly('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js');

//        $startDate = date("Y-m-01", strtotime($currentDate));
//        $endDate = date("Y-m-d", strtotime('+1 month', strtotime($startDate)));
        $deliveries = $this->deliveryRepository->getModel()
            ->leftJoin('ec_orders', 'ec_delivery_pickup.order_id', '=', 'ec_orders.id')
            ->leftJoin('payments', 'payments.order_id', '=', 'ec_orders.id')
            ->where(DB::raw("(delivery_status = '2' AND pickup_status = '2')"), '=', false)
            ->where('payments.status', '!=',  PaymentStatusEnum::FAILED)
            ->where('ec_orders.status', '!=',  OrderStatusEnum::CANCELED)
            ->get();

        $result = $deliveries->toArray();
        if (count($deliveries)) {
            for ($i = count($deliveries) - 1; $i >= 0; $i --) {
                if ($deliveries[$i]->delivery_status == DeliveryStatusEnum::COMPLETED && $deliveries[$i]->pickup_status == DeliveryStatusEnum::COMPLETED) {
                    continue;
                }
                $result[$i]['product_name'] = $deliveries[$i]->product->name;
                $result[$i]['backgroundColor'] = $deliveries[$i]->product->color;
                $result[$i]['type'] = '5';

                $deliveryDate = DateTime::createFromFormat('Y-m-d', $deliveries[$i]->delivery_date);
                $pickupDate = DateTime::createFromFormat('Y-m-d', $deliveries[$i]->pickup_date);

                if ($deliveries[$i]->delivery_status == DeliveryStatusEnum::PENDING) {
                    $result[$i]['start'] = date('Y-m-d', strtotime('+1 day', $deliveryDate->getTimestamp())) . ' ' . date('h:s:i', strtotime($deliveries[$i]->delivery_time));
                    $result[$i]['end'] = date('Y-m-d', strtotime('-1 day', $pickupDate->getTimestamp())) . ' ' . date('h:s:i', strtotime($deliveries[$i]->pickup_time));

                    // when the product is daily, the duration is removed
                    if ($result[$i]['start'] > $result[$i]['end']) {
                        array_splice($result, $i, 1);
                    }

                    // add delivery event
                    $delivery = [];
                    $delivery['start'] = date('Y-m-d', strtotime($deliveries[$i]->delivery_date)) . ' ' . date('h:s:i', strtotime($deliveries[$i]->delivery_time));
                    $delivery['end'] = date('Y-m-d', strtotime($deliveries[$i]->delivery_date)) . ' ' . date('h:s:i', strtotime($deliveries[$i]->delivery_time));
                    $delivery['name'] = $deliveries[$i]->name;
                    $delivery['phone'] = $deliveries[$i]->phone;
                    $delivery['email'] = $deliveries[$i]->email;
                    $delivery['country'] = $deliveries[$i]->country;
                    $delivery['state'] = $deliveries[$i]->state;
                    $delivery['city'] = $deliveries[$i]->city;
                    $delivery['address'] = $deliveries[$i]->address;
                    $delivery['order_id'] = $deliveries[$i]->order_id;
                    $delivery['product_id'] = $deliveries[$i]->product_id;
                    $delivery['zip_code'] = $deliveries[$i]->zip_code;
                    $delivery['comment'] = $deliveries[$i]->comment;
                    $delivery['product_name'] = $deliveries[$i]->product->name;
                    $delivery['status'] = $deliveries[$i]->delivery_status->getValue();
                    $delivery['id'] = $deliveries[$i]->id;
                    $delivery['disabled'] = 0;

                    // if customer delivery flag is set, set type customer delivery
                    if ($deliveries[$i]->customer_delivery == 1) {
                        $delivery['type'] = DeliveryTypeEnum::CUSTOMER_DELIVERY;
                        // when the order is customer pickup or delivery, set the color from product.
                        $delivery['backgroundColor'] = $deliveries[$i]->order->products[0]->store->color;
                        $delivery['storeId'] = $deliveries[$i]->order->products[0]->store_id;
                    } else {
                        $delivery['type'] = DeliveryTypeEnum::DELIVERY;
                    }

                    $result[] = $delivery;

                    // add pickup event
                    $pickup = [];
                    $pickup['start'] = date('Y-m-d', strtotime($deliveries[$i]->pickup_date)) . ' ' . date('h:s:i', strtotime($deliveries[$i]->pickup_time));
                    $pickup['end'] = date('Y-m-d', strtotime($deliveries[$i]->pickup_date)) . ' ' . date('h:s:i', strtotime($deliveries[$i]->pickup_time));
                    $pickup['name'] = $deliveries[$i]->name;
                    $pickup['phone'] = $deliveries[$i]->phone;
                    $pickup['email'] = $deliveries[$i]->email;
                    $pickup['country'] = $deliveries[$i]->country;
                    $pickup['state'] = $deliveries[$i]->state;
                    $pickup['city'] = $deliveries[$i]->city;
                    $pickup['address'] = $deliveries[$i]->address;
                    $pickup['order_id'] = $deliveries[$i]->order_id;
                    $pickup['product_id'] = $deliveries[$i]->product_id;
                    $pickup['zip_code'] = $deliveries[$i]->zip_code;
                    $pickup['comment'] = $deliveries[$i]->comment;
                    $pickup['product_name'] = $deliveries[$i]->product->name;
                    $pickup['status'] = $deliveries[$i]->pickup_status->getValue();
                    $pickup['id'] = $deliveries[$i]->id;
                    // if delivery is pending,set pickup disabled.
                    $pickup['disabled'] = 1;

                    // set event type from customer_pickup flag
                    if ($deliveries[$i]->customer_pickup == 1) {
                        $pickup['type'] = DeliveryTypeEnum::CUSTOMER_PICKUP;
                        $pickup['backgroundColor'] = $deliveries[$i]->order->products[0]->store->color;
                        $pickup['storeId'] = $deliveries[$i]->order->products[0]->store_id;
                    } else {
                        $pickup['type'] = DeliveryTypeEnum::PICKUP;
                    }

                    $result[] = $pickup;

                } else if ($deliveries[$i]->pickup_status == DeliveryStatusEnum::PENDING) {
                    $result[$i]['start'] = date('Y-m-d', strtotime($deliveries[$i]->delivery_date)) . ' ' . date('h:s:i', strtotime($deliveries[$i]->delivery_time));
                    $result[$i]['end'] = date('Y-m-d', strtotime('-1 day', $pickupDate->getTimestamp())) . ' ' . date('h:s:i', strtotime($deliveries[$i]->pickup_time));

                    // add pickup event
                    $pickup = [];
                    $pickup['start'] = date('Y-m-d', strtotime($deliveries[$i]->pickup_date)) . ' ' . date('h:s:i', strtotime($deliveries[$i]->pickup_time));
                    $pickup['end'] = date('Y-m-d', strtotime($deliveries[$i]->pickup_date)) . ' ' . date('h:s:i', strtotime($deliveries[$i]->pickup_time));
                    $pickup['name'] = $deliveries[$i]->name;
                    $pickup['phone'] = $deliveries[$i]->phone;
                    $pickup['email'] = $deliveries[$i]->email;
                    $pickup['country'] = $deliveries[$i]->country;
                    $pickup['state'] = $deliveries[$i]->state;
                    $pickup['city'] = $deliveries[$i]->city;
                    $pickup['address'] = $deliveries[$i]->address;
                    $pickup['order_id'] = $deliveries[$i]->order_id;
                    $pickup['product_id'] = $deliveries[$i]->product_id;
                    $pickup['zip_code'] = $deliveries[$i]->zip_code;
                    $pickup['comment'] = $deliveries[$i]->comment;
                    $pickup['product_name'] = $deliveries[$i]->product->name;
                    $pickup['status'] = $deliveries[$i]->pickup_status->getValue();
                    $pickup['id'] = $deliveries[$i]->id;

                    if ($deliveries[$i]->customer_pickup == 1) {
                        $pickup['type'] = DeliveryTypeEnum::CUSTOMER_PICKUP;
                        $pickup['backgroundColor'] = $deliveries[$i]->order->products[0]->store->color;
                        $pickup['storeId'] = $deliveries[$i]->order->products[0]->store_id;
                    } else {
                        $pickup['type'] = DeliveryTypeEnum::PICKUP;
                    }
                    $result[] = $pickup;
                } else {
                    $result[$i]['start'] = date('Y-m-d', strtotime($deliveries[$i]->delivery_date)) . ' ' . date('h:s:i', strtotime($deliveries[$i]->delivery_time));
                    $result[$i]['end'] = date('Y-m-d', strtotime($deliveries[$i]->pickup_date)) . ' ' . date('h:s:i', strtotime($deliveries[$i]->pickup_time));
                }
            }
        } else {
            $result = [];
        }

        $list=array();
        $month = date('m');
        $year = date('Y');

        for ($d = 1; $d <= 31; $d++) {
            $time=mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $list[] = date('Y-m-d', $time);
            }
        }

        $maxCount = 0;
        for ($i = 0; $i < count($list); $i++) {
            $count = DB::table('ec_delivery_pickup')
                ->select(DB::raw('count(*) as count'))
                ->where('delivery_date', '<=', $list[$i])
                ->where('pickup_date', '>=', $list[$i])
                ->get()
                ->toArray();
            if ($count[0]->count > $maxCount) {
                $maxCount = $count[0]->count;
            }
        }

        $stores = DB::table('ec_store_locators')->get();

        return view('plugins/ecommerce::deliveries.calendar', compact('result', 'maxCount', 'stores'));
    }
}
