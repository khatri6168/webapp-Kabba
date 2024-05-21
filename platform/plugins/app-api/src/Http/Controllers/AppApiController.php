<?php

namespace Botble\AppApi\Http\Controllers;
use Illuminate\Http\Request;
use Botble\Contact\Models\Contact;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Contact\Models\ContactNote;
use Botble\Location\Models\State;
use Botble\Ecommerce\Models\Order;

use Botble\Ecommerce\Repositories\Interfaces\OrderInterface;
use Exception;
use Botble\Ecommerce\Facades\ProductCategoryHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Services\Products\GetProductService;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Botble\Ecommerce\Repositories\Interfaces\StoreLocatorInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductCategoryInterface;
use Botble\Ecommerce\Repositories\Interfaces\CustomerInterface;
use Botble\Ecommerce\Repositories\Interfaces\OrderAddressInterface;
use Botble\Ecommerce\Repositories\Interfaces\OrderProductInterface;
use Botble\Payment\Repositories\Interfaces\PaymentInterface;
use Botble\Ecommerce\Repositories\Interfaces\DeliveryPickUpInterface;
use Botble\Ecommerce\Repositories\Interfaces\OrderMachineHourInterface;

use Illuminate\Support\Arr;
use Botble\Ecommerce\Enums\OrderStatusEnum;
use Botble\Ecommerce\Enums\ShippingCodStatusEnum;
use Botble\Ecommerce\Enums\ShippingMethodEnum;
use Botble\Base\Facades\BaseHelper;
use Botble\Ecommerce\Enums\DeliveryStatusEnum;
use Illuminate\Support\Facades\Hash;
use Botble\Ecommerce\Events\ProductQuantityUpdatedEvent;
use Botble\Ecommerce\Events\OrderCreated;
use Botble\Ecommerce\Models\DeliveryPickup;
use Botble\Ecommerce\Models\OrderAddress;
use Botble\Payment\Enums\PaymentStatusEnum;
use Illuminate\Support\Str;
use Botble\Terms\Models\Terms;

use Botble\Media\Facades\RvMedia;
use Botble\Media\Models\MediaFile;
use Botble\Media\Models\MediaFolder;
use Carbon\Carbon;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

use DateTime;
use DB;
use Validator;
class AppApiController extends BaseController
{
    public function __construct(protected OrderInterface $orderRepository, protected StoreLocatorInterface $storeLocatorRepository, protected ProductInterface $productRepository, protected CustomerInterface $customerRepository, protected OrderAddressInterface $orderAddressRepository, protected OrderProductInterface $orderProductRepository, protected DeliveryPickUpInterface $deliveryPickUpRepository, protected OrderMachineHourInterface $orderMachineHourRepository)
    {
    }

    public function createContact(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'nullable|required_without_all:last_name,phone,phone2,email,skype',
                'last_name' => 'nullable|required_without_all:first_name,phone,phone2,email,skype',
                'phone' => 'nullable|required_without_all:first_name,last_name,phone2,email,skype',
                'phone2' => 'nullable|required_without_all:first_name,last_name,phone,email,skype',
                'email' => 'nullable|required_without_all:first_name,last_name,phone,phone2,skype|email',
                'skype' => 'nullable|required_without_all:first_name,last_name,phone,phone2,email',
                'address' => 'nullable',
                'city' => 'nullable',
                'state' => 'nullable',
                'zipcode' => 'nullable',
                'country' => 'nullable',
                'company' => 'nullable',
                'phone_2' => 'nullable',
                'tax_id' => 'nullable',
                'url' => 'nullable|url',
                'company_address' => 'nullable',
                'company_city' => 'nullable',
                'company_state' => 'nullable',
                'company_zipcode' => 'nullable',
                'company_country' => 'nullable',
                'delivery_first_name' => 'nullable',
                'delivery_last_name' => 'nullable',
                'delivery_mobile' => 'nullable',
                'delivery_mobile2' => 'nullable',
                'delivery_address' => 'nullable',
                'delivery_city' => 'nullable',
                'delivery_state' => 'nullable',
                'delivery_zipcode' => 'nullable',
                'delivery_country' => 'nullable',
            ]);

            $contact = Contact::create($request->all());
        } catch (Exception $e) {
            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Error : ' . $e->getMessage(),
                    'success' => false,
                ],
                422,
            );
        }

        return response()->json(
            [
                'errors' => [],
                'data' => $contact,
                'message' => 'Contact data stored successfully..',
                'success' => true,
            ],
            200,
        );
    }

    public function getStates()
    {
        $states = State::all();
        return response()->json(
            [
                'errors' => [],
                'data' => $states,
                'success' => true,
            ],
            200,
        );
    }

    public function getOrders(Request $request)
    {
        $limit = $request->limit ?? 10;
        $page = $request->page ?? 1;
        // $orders = DB::table('ec_orders')
        // ->leftJoin('ec_customers', 'ec_customers.id', '=', 'ec_orders.user_id')
        // ->select(['ec_orders.*', 'ec_customers.*'])
        // ->where('is_finished',1)
        // ->paginate($limit);
        $orders = $this->orderRepository->advancedGet([
            'condition' => [
                'is_finished' => 1,
            ],
            'paginate' => [
                'per_page' => $limit,
                'current_paged' => $page,
            ],
            'withCount' => ['orderProducts'],
            'with' => ['orderProducts', 'address', 'payment', 'orderMachineHours'],
            'order_by' => ['created_at' => 'DESC'],
        ]);

        if (count($orders) == 0) {
            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Orders not found.',
                    'data' => (object) [],
                    'success' => false,
                ],
                404,
            );
        }

        foreach ($orders as $row) {
            $row->order_type = BaseHelper::clean($row->payment->payment_channel->label() == 'Cash on delivery (COD)' ? 'COD' : 'Credit / Debit Card');
        }

        return response()->json(
            [
                'errors' => [],
                'message' => 'Orders successfully found.',
                'data' => $orders,
                'success' => true,
            ],
            200,
        );
    }

    public function getOrderDetail(Request $request)
    {
        $id = $request->order_id;

        $order = $this->orderRepository->getFirstBy(['id' => $id, 'is_finished' => 1], [], ['orderProducts','orderProducts.store', 'user','address', 'hasShippingAddress','hasBillingAddress', 'payment', 'orderMachineHours']);

        if (!$order) {
            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Order not found.',
                    'data' => (object) [],
                    'success' => false,
                ],
                404,
            );
        }

        $order->order_type = BaseHelper::clean($order->payment->payment_channel->label() == 'Cash on delivery (COD)' ? 'COD' : 'Credit / Debit Card');

        return response()->json(
            [
                'errors' => [],
                'message' => 'Order successfully found.',
                'data' => $order,
                'success' => true,
            ],
            200,
        );
    }

    # place order api start
    public function placeOrder(Request $request)
    {
        $data = $request->all();
        $products = $this->products($data['carts']);

        foreach ($products as $product) {
            if ($product->isOutOfStock()) {
                return response()->json(
                    [
                        'errors' => [],
                        'message' => 'Product ' . $product->original_product->name . ' out of stock!',
                        'data' => (object) [],
                        'success' => false,
                    ],
                    200,
                );
            }
        }

        $cartSubTotal = array_sum(array_column($data['carts'], 'subTotal'));
        $minimumAmount = format_price(EcommerceHelper::getMinimumOrderAmount());
        $addMoreAmount = format_price(EcommerceHelper::getMinimumOrderAmount() - $cartSubTotal);
        if (EcommerceHelper::getMinimumOrderAmount() > $cartSubTotal) {
            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Minimum order amount is ' . $minimumAmount . ', you need to buy more ' . $addMoreAmount . ' to place an order!',
                    'data' => (object) [
                        'minimum_amount' => $minimumAmount,
                        'add_more' => $addMoreAmount,
                    ],
                    'success' => false,
                ],
                200,
            );
        }

        $primaryEmail = $data['email'] ?? null;
        $contactData = [
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'name' => $data['first_name'] . ' ' . $data['last_name'] ?? null,
            'email' => $primaryEmail,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'zipcode' => $data['zipcode'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
            'country' => $data['country'] ?? null,
            'note' => $data['note'] ?? null,
            'same_as_delivery' => $data['same_as_delivery'],
            'first_name_d' => $data['same_as_delivery'] == true ? $data['first_name'] ?? null : $data['delivery_first_name'] ?? null,
            'last_name_d' => $data['same_as_delivery'] == true ? $data['last_name'] ?? null : $data['delivery_last_name'] ?? null,
            'delivery_email' => $data['same_as_delivery'] == true ? $data['email'] ?? null : $data['delivery_email'] ?? null,
            'mobile_d' => $data['same_as_delivery'] == true ? $data['phone'] ?? null : $data['delivery_mobile'] ?? null,
            'delivery_address' => $data['same_as_delivery'] == true ? $data['address'] ?? null : $data['delivery_address'] ?? null,
            'delivery_zipcode' => $data['same_as_delivery'] == true ? $data['zipcode'] ?? null : $data['delivery_zipcode'] ?? null,
            'delivery_city' => $data['same_as_delivery'] == true ? $data['city'] ?? null : $data['delivery_city'] ?? null,
            'delivery_state' => $data['same_as_delivery'] == true ? $data['state'] ?? null : $data['delivery_state'] ?? null,
            'delivery_country' => $data['same_as_delivery'] == true ? $data['country'] ?? null : $data['delivery_country'] ?? null,
        ];

        DB::beginTransaction();
        $objContact = Contact::updateOrCreate(
            ['email' => $contactData['email']], // Search condition
            $contactData, // Data to update or create
        );

        $customer = $this->customerRepository->firstOrCreate(
            ['email' => $contactData['email']],
            [
                'name' => BaseHelper::clean($contactData['name']),
                'phone' => BaseHelper::clean($contactData['phone']),
                'password' => Hash::make($contactData['name'] . '@123'),
                'type' => 'Guest',
            ],
        );

        $token = md5(Str::random(40));

        $orderData = [
            'amount' => round(Arr::get($data, 'total_amount'), 2),
            'user_id' => $customer->id,
            'shipping_method' => Arr::get($data, 'shipping_method') ?: ShippingMethodEnum::DEFAULT,
            'shipping_option' => Arr::get($data, 'shipping_option'),
            'shipping_amount' => round(Arr::get($data, 'shipping_amount') ?: 0, 2),
            'tax_amount' => round(Arr::get($data, 'tax_amount') ?: 0, 2),
            'sub_total' => round($cartSubTotal ?: 0, 2),
            'coupon_code' => Arr::get($data, 'coupon_code'),
            'discount_amount' => Arr::get($data, 'discount_amount') ?: 0,
            'promotion_amount' => Arr::get($data, 'promotion_amount') ?: 0,
            'discount_description' => $request->input('discount_description'),
            'description' => $data['note'],
            'is_confirmed' => 1,
            'is_finished' => 1,
            'status' => OrderStatusEnum::PROCESSING,
            'token' => $token,
            'os' => 'iOS',
        ];

        $order = $this->orderRepository->createOrUpdate($orderData);

        if ($order) {
            $chargeId = Str::upper(Str::random(10));
            if (isset($data['card_number']) && !empty($data['card_number']) && isset($data['mm_yy']) && !empty($data['mm_yy']) && isset($data['cvc']) && !empty($data['cvc'])) {
                $responseData = [];
                $responseData['error'] = false;
                $responseData['message'] = '';

                // Set the customer's Bill To address
                $customerAddress = new AnetAPI\CustomerAddressType();
                $customerAddress->setFirstName($contactData['name'] ?? null);
                // $customerAddress->setLastName("Johnson");
                // $customerAddress->setCompany("Souveniropolis");
                $customerAddress->setAddress($contactData['address'] ?? null);
                $customerAddress->setCity($contactData['city'] ?? null);
                $customerAddress->setState($contactData['state'] ?? null);
                $customerAddress->setZip($contactData['zipcode'] ?? null);
                $customerAddress->setCountry($contactData['country'] ?? null);
                $customerAddress->setEmail($contactData['email'] ?? null);

                // Set the customer's identifying information
                $customerData = new AnetAPI\CustomerDataType();
                $customerData->setType('individual');
                $customerData->setId($customer->id ?? null);
                $customerData->setEmail($customer->email ?? ($contactData['email'] ?? null));

                // Create order information
                $orderType = new AnetAPI\OrderType();
                $orderType->setInvoiceNumber($order->code ?? null);
                // $order->setDescription("Golf Shirts");

                $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                $merchantAuthentication->setName(setting('payment_authorizenet_merchant_login_id'));
                $merchantAuthentication->setTransactionKey(setting('payment_authorizenet_merchant_transaction_key'));

                $refId = 'rentalapp' . time();
                $cardNumber = preg_replace('/\s+/', '', $data['card_number']);
                $expiry = $data['mm_yy'];
                $expiryData = explode('/', $expiry);
                $expiration_month = $expiryData[0];
                $expiration_year = $expiryData[1];

                // Create the payment data for a credit card
                $creditCard = new AnetAPI\CreditCardType();
                $creditCard->setCardNumber($cardNumber);
                $creditCard->setExpirationDate('20' . $expiration_year . '-' . $expiration_month);
                $creditCard->setCardCode($data['cvc']);

                // Add the payment data to a paymentType object
                $paymentCreditCard = new AnetAPI\PaymentType();
                $paymentCreditCard->setCreditCard($creditCard);

                $shippingProfiles[] = $customerAddress;
                $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
                $paymentProfile->setCustomerType('individual');
                $paymentProfile->setBillTo($customerAddress);
                $paymentProfile->setPayment($paymentCreditCard);
                $paymentProfiles[] = $paymentProfile;

                // Create a new CustomerProfileType and add the payment profile object
                $customerProfile = new AnetAPI\CustomerProfileType();
                $customerProfile->setDescription('Customer Order Profile');
                // $customerProfile->setMerchantCustomerId("M_" . time());
                $customerProfile->setMerchantCustomerId('RA_' . time());
                $customerProfile->setEmail($customer->email ?? ($contactData['email'] ?? null));
                $customerProfile->setpaymentProfiles($paymentProfiles);
                $customerProfile->setShipToList($shippingProfiles);
                // dd($customerProfile);

                // Assemble the complete transaction request
                $customerProfileRequest = new AnetAPI\CreateCustomerProfileRequest();
                $customerProfileRequest->setMerchantAuthentication($merchantAuthentication);
                $customerProfileRequest->setRefId($refId);
                $customerProfileRequest->setProfile($customerProfile);

                // Create the controller and get the response
                $controller = new AnetController\CreateCustomerProfileController($customerProfileRequest);
                if (env('APP_ENV') == 'production') {
                    $cpResponse = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                } else {
                    $cpResponse = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
                }

                if ($cpResponse != null && $cpResponse->getMessages()->getResultCode() == 'Ok') {
                    // echo "Succesfully created customer profile : " . $cpResponse->getCustomerProfileId() . "\n";
                    $customerProfileId = $cpResponse->getCustomerProfileId();
                    $paymentProfiles = $cpResponse->getCustomerPaymentProfileIdList();
                    $paymentProfileId = $paymentProfiles[0];
                    $order->authorize_customer_id = $customerProfileId;
                    $order->authorize_customer_payment_id = $paymentProfileId;
                    $order->save();
                    // dd($orderDetails);
                } else {
                    // echo "ERROR :  Invalid response\n";
                    $errorMessages = $cpResponse->getMessages()->getMessage();
                    $errorMessage = $errorMessages[0]->getText();
                    // echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
                    // return redirect()->back()->withErrors(['error' => $errorMessages]);
                    $orderId = $order->id;
                    $responseData['error'] = true;
                    $responseData['message'] = $errorMessage;
                    if ($responseData['error'] == true) {
                        $responseData['checkoutUrl'] = route('payments.authorizenet.error') . '?session_id=' . base64_encode($orderId);
                        $paymentStatus = PaymentStatusEnum::FAILED;
                    }
                    $authorizenetPaymnetData = [
                        'amount' => $order->amount,
                        'currency' => cms_currency()->getDefaultCurrency()->title,
                        'charge_id' => $chargeId,
                        'order_id' => $order->id,
                        'customer_id' => $order->user_id,
                        'customer_type' => 'Botble\Ecommerce\Models\Customer',
                        'payment_channel' => AUTHORIZENET_PAYMENT_METHOD_NAME,
                        'status' => $paymentStatus,
                        'message' => $responseData['message'] ?? null,
                    ];
                    $sessionArr = ["authorizenetPaymnetData_$orderId" => $authorizenetPaymnetData];
                    return $responseData;
                }

                $profileToCharge = new AnetAPI\CustomerProfilePaymentType();
                $profileToCharge->setCustomerProfileId($customerProfileId);
                $paymentProfile = new AnetAPI\PaymentProfileType();
                $paymentProfile->setPaymentProfileId($paymentProfileId);
                $profileToCharge->setPaymentProfile($paymentProfile);

                // Create a TransactionRequestType object and add the previous objects to it
                $transactionRequestType = new AnetAPI\TransactionRequestType();
                $transactionRequestType->setTransactionType('authCaptureTransaction'); //authCaptureTransaction
                $transactionRequestType->setAmount($order->amount); // $order->amount
                // $transactionRequestType->setPayment($paymentCreditCard);
                $transactionRequestType->setProfile($profileToCharge);

                // $transactionRequestType->setOrder($order);
                // $transactionRequestType->setBillTo($customerAddress);
                // $transactionRequestType->setShipTo($customerAddress);
                // $transactionRequestType->setCustomer($customerData);

                // Assemble the complete transaction request
                $requests = new AnetAPI\CreateTransactionRequest();
                $requests->setMerchantAuthentication($merchantAuthentication);
                $requests->setRefId($refId);
                $requests->setTransactionRequest($transactionRequestType);

                // Create the controller and get the response
                $controller = new AnetController\CreateTransactionController($requests);
                if (env('APP_ENV') == 'production') {
                    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                } else {
                    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
                }

                if ($response != null) {
                    // Check to see if the API request was successfully received and acted upon
                    if ($response->getMessages()->getResultCode() == 'Ok') {
                        // Since the API request was successful, look for a transaction response
                        // and parse it to display the results of authorizing the card
                        $tresponse = $response->getTransactionResponse();
                        // dd($tresponse);

                        if ($tresponse != null && $tresponse->getMessages() != null) {
                            // echo " Transaction Response code : " . $tresponse->getResponseCode() . "\n";
                            // echo "Charge Tokenized Credit Card AUTH CODE : " . $tresponse->getAuthCode() . "\n";
                            // echo "Charge Tokenized Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
                            // echo " Code : " . $tresponse->getMessages()[0]->getCode() . "\n";
                            // echo " Description : " . $tresponse->getMessages()[0]->getDescription() . "\n";
                            $message_text = $tresponse->getMessages()[0]->getDescription() . ', Transaction ID: ' . $tresponse->getTransId();
                            $msg_type = 'success_msg';
                            $responseData['error'] = false;
                            $responseData['message'] = $message_text;

                            /* \App\PaymentLogs::create([
                                'amount' => $input['amount'],
                                'response_code' => $tresponse->getResponseCode(),
                                'transaction_id' => $tresponse->getTransId(),
                                'auth_id' => $tresponse->getAuthCode(),
                                'message_code' => $tresponse->getMessages()[0]->getCode(),
                                'name_on_card' => trim($input['owner']),
                                'quantity'=>1
                            ]); */
                        } else {
                            $message_text = 'There were some issue with the payment. Please try again later.';
                            $msg_type = 'error_msg';
                            $responseData['error'] = true;
                            $responseData['message'] = $message_text;

                            if ($tresponse->getErrors() != null) {
                                $message_text = $tresponse->getErrors()[0]->getErrorText();
                                $msg_type = 'error_msg';
                                $responseData['error'] = true;
                                $responseData['message'] = $message_text;
                            }
                        }
                        // Or, print errors if the API request wasn't successful
                    } else {
                        $message_text = 'There were some issue with the payment. Please try again later.';
                        $msg_type = 'error_msg';
                        $responseData['error'] = true;
                        $responseData['message'] = $message_text;

                        $tresponse = $response->getTransactionResponse();

                        if ($tresponse != null && $tresponse->getErrors() != null) {
                            $message_text = $tresponse->getErrors()[0]->getErrorText();
                            $msg_type = 'error_msg';
                            $responseData['error'] = true;
                            $responseData['message'] = $message_text;
                        } else {
                            $message_text = $response->getMessages()->getMessage()[0]->getText();
                            $msg_type = 'error_msg';
                            $responseData['error'] = true;
                            $responseData['message'] = $message_text;
                        }
                    }

                    $chargeId = $tresponse->getTransId() == 0 ? $refId : $tresponse->getTransId();
                } else {
                    $chargeId = $refId;
                    $message_text = 'No response returned';
                    $msg_type = 'error_msg';
                    $responseData['error'] = true;
                    $responseData['message'] = $message_text;
                }
                $chargeId = $chargeId ?? $refId;
                $orderId = $order->id;
                $paymentStatus = PaymentStatusEnum::COMPLETED;
                $responseData['checkoutUrl'] = route('payments.authorizenet.success') . '?session_id=' . base64_encode($orderId);
                if ($responseData['error'] == true) {
                    $responseData['checkoutUrl'] = route('payments.authorizenet.error') . '?session_id=' . base64_encode($orderId);
                    $paymentStatus = PaymentStatusEnum::FAILED;
                }
                $authorizenetPaymnetData = [
                    'amount' => $order->amount,
                    'currency' => cms_currency()->getDefaultCurrency()->title,
                    'charge_id' => $chargeId,
                    'order_id' => $order->id,
                    'customer_id' => $order->user_id,
                    'customer_type' => 'Botble\Ecommerce\Models\Customer',
                    'payment_channel' => AUTHORIZENET_PAYMENT_METHOD_NAME,
                    'status' => $paymentStatus,
                    'message' => $responseData['message'] ?? null,
                ];
                $sessionArr = session(["authorizenetPaymnetData_$orderId" => $authorizenetPaymnetData]);
                if ($responseData['error'] == true) {
                    return $responseData;
                }
            }

            if (isset($authorizenetPaymnetData) && !empty($authorizenetPaymnetData)) {
                $payment = app(PaymentInterface::class)->createOrUpdate($authorizenetPaymnetData);
            } else {
                $payment = app(PaymentInterface::class)->createOrUpdate([
                    'amount' => $order->amount,
                    'currency' => cms_currency()->getDefaultCurrency()->title,
                    'payment_channel' => $data['payment_method'],
                    'status' => $request->input('payment_status', PaymentStatusEnum::PENDING),
                    'payment_type' => 'confirm',
                    'order_id' => $order->id,
                    'charge_id' => $chargeId,
                    'user_id' => $customer->id,
                ]);
            }

            $order->payment_id = $payment->id;
            $order->save();

            $this->orderAddressRepository->create([
                'name' => $contactData['name'],
                'phone' => $contactData['phone'],
                'email' => $contactData['email'],
                'state' => $contactData['state'],
                'city' => $contactData['city'],
                'zip_code' => $contactData['zipcode'],
                'country' => $contactData['country'],
                'address' => $contactData['address'],
                'order_id' => $order->id,
            ]);

            if ($data['same_as_delivery'] == false) {
                $this->orderAddressRepository->create([
                    'name' => $contactData['first_name_d'] . ' ' . $contactData['last_name_d'],
                    'phone' => $contactData['mobile_d'],
                    'email' => $contactData['delivery_email'],
                    'state' => $contactData['delivery_state'],
                    'city' => $contactData['delivery_city'],
                    'zip_code' => $contactData['delivery_zipcode'],
                    'country' => $contactData['delivery_country'],
                    'address' => $contactData['delivery_address'],
                    'type' => 'billing_address',
                    'order_id' => $order->id,
                ]);
            }

            foreach ($products as $productItem) {
                $productItem = $productItem->toArray();
                $quantity = Arr::get($productItem, 'quantity', 1);
                $orderProduct = [
                    'order_id' => $order->id,
                    'product_id' => Arr::get($productItem, 'id'),
                    'product_name' => Arr::get($productItem, 'name'),
                    'product_image' => Arr::get($productItem, 'image'),
                    'qty' => $quantity,
                    'weight' => Arr::get($productItem, 'weight'),
                    'price' => Arr::get($productItem, 'original_price'),
                    'tax_amount' => Arr::get($productItem['carts'], 'taxTotal'),
                    'options' => Arr::get($productItem, 'formateCart', []),
                    'product_options' => Arr::get($productItem['formateCart'], 'options', []),
                    'product_type' => Arr::get($productItem, 'product_type'),
                    'store_id' => Arr::get($productItem['carts'], 'store_id'),
                ];

                $orderProduct = $this->orderProductRepository->create($orderProduct);
                $product = $this->productRepository->findById(Arr::get($productItem, 'id'));

                // save delivery_pickup data
                $deliveryData = [
                    'name' => $contactData['name'],
                    'phone' => $contactData['mobile_d'],
                    'email' => $contactData['delivery_email'],
                    'country' => $contactData['delivery_country'],
                    'state' => $contactData['delivery_state'],
                    'city' => $contactData['delivery_city'],
                    'address' => $contactData['delivery_address'],
                    'order_id' => $order->id,
                    'zip_code' => $contactData['delivery_zipcode'],
                    'comment' => '',
                    'product_id' => Arr::get($productItem, 'id'),
                ];

                $deliveryDate = DateTime::createFromFormat('m/d/Y', $productItem['carts']['deldate']);
                $deliveryData['delivery_date'] = $deliveryDate->format('Y-m-d');
                $deliveryData['delivery_status'] = DeliveryStatusEnum::PENDING()->getValue();

                // save delivery_pickup data
                if (isset($productItem['carts']['delivery']) && !is_null($productItem['carts']['delivery']) && $productItem['carts']['delivery']) {
                    $deliveryData['customer_delivery'] = SHOP_DELIVERY;
                } else {
                    $deliveryData['customer_delivery'] = CUSTOMER_DELIVERY;
                }

                if ($product->rental_type == RENTAL_TYPE_WEEKEND) {
                    $deliveryData['delivery_time'] = '14:00:00';
                } else {
                    $deliveryData['delivery_time'] = '09:00:00';
                }

                $duration = 1 * $quantity;
                if ($product->rental_type == RENTAL_TYPE_DAILY) {
                    $duration = $duration;
                } elseif ($product->rental_type == RENTAL_TYPE_WEEKEND) {
                    $duration = $duration * 3;
                } elseif ($product->rental_type == RENTAL_TYPE_WEEKLY) {
                    $duration = $duration * 7;
                } elseif ($product->rental_type == RENTAL_TYPE_MONTHLY) {
                    $duration = $duration * 30;
                }

                // Calculate pickup date based on the adjusted duration
                $pickDate = date('Y-m-d', strtotime("+$duration day", $deliveryDate->getTimestamp()));

                $deliveryData['pickup_date'] = $pickDate;
                $deliveryData['pickup_time'] = '09:00:00';
                $deliveryData['pickup_status'] = DeliveryStatusEnum::PENDING()->getValue();
                if (isset($productItem['carts']['pickup']) && !is_null($productItem['carts']['pickup']) && $productItem['carts']['pickup']) {
                    $deliveryData['customer_pickup'] = SHOP_PICKUP;
                } else {
                    $deliveryData['customer_pickup'] = CUSTOMER_PICKUP;
                }

                $deliveryPickUpData = $this->deliveryPickUpRepository->create($deliveryData);

                // add order_machine_hour
                $allocated = 0;
                if ($product->rental_type != 0 && $product->hour_track == 1) {
                    if ($product->rental_type == RENTAL_TYPE_DAILY) {
                        $allocated = get_ecommerce_setting('daily_hours') * $orderProduct->qty;
                    } elseif ($product->rental_type == RENTAL_TYPE_WEEKEND) {
                        $allocated = get_ecommerce_setting('weekend_hours') * $orderProduct->qty;
                    } elseif ($product->rental_type == RENTAL_TYPE_WEEKLY) {
                        $allocated = get_ecommerce_setting('weekly_hours') * $orderProduct->qty;
                    } elseif ($product->rental_type == RENTAL_TYPE_MONTHLY) {
                        $allocated = get_ecommerce_setting('monthly_hours') * $orderProduct->qty;
                    }
                }

                $data = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'start' => 0,
                    'end' => 0,
                    'allocated' => $allocated,
                    'over' => 0,
                    'over_rate' => $product->over_rate,
                    'total' => 0,
                    'total_cost' => 0,
                ];

                $this->orderMachineHourRepository->create($data);

                if (!$product) {
                    continue;
                }

                $ids = [$product->id];
                if ($product->is_variation && $product->original_product) {
                    $ids[] = $product->original_product->id;
                }

                $this->productRepository->getModel()->whereIn('id', $ids)->where('with_storehouse_management', 1)->where('quantity', '>=', $quantity)->decrement('quantity', $quantity);

                event(new ProductQuantityUpdatedEvent($product));
            }

            event(new OrderCreated($order));
        }
        DB::commit();
        $signUrl = $this->getSignTerms($token);
        return response()->json(
            [
                'errors' => [],
                'success' => true,
                'message' => 'Order successfully placed.',
                'signUrl' => $signUrl,
                'data' => $order,
            ],
            200,
        );
    }

    public function products($cartContent)
    {
        $productIds = array_keys($cartContent);
        $products = collect();
        $weight = 0;
        if ($productIds) {
            $with = ['variationInfo', 'variationInfo.configurableProduct', 'variationInfo.configurableProduct.slugable', 'variationProductAttributes', 'options'];

            if (is_plugin_active('marketplace')) {
                $with = array_merge($with, ['variationInfo.configurableProduct.store', 'variationInfo.configurableProduct.store.slugable']);
            }

            $products = app(ProductInterface::class)->getProducts([
                'condition' => [['ec_products.id', 'IN', $productIds]],
                'with' => $with,
            ]);
        }

        $productsInCart = new EloquentCollection();

        if ($products->count()) {
            foreach ($cartContent as $cartItem) {
                $product = $products->firstWhere('id', $cartItem['id']);
                if ($product) {
                    $productCartFormat = [];
                    $productCartFormat['image'] = $product['image'] ?? null;
                    $productCartFormat['attributes'] = $product['variationProductAttributes']->implode(',');
                    if (isset($product['options'][0]['id'])) {
                        $productCartFormat['options']['optionCartValue'][$product['options'][0]['id']] = $cartItem['options'];
                        $productCartFormat['options']['optionInfo'][$product['options'][0]['id']] = $product['options'][0]['name'];
                    } else {
                        $productCartFormat['options'] = [];
                    }
                    $productCartFormat['sku'] = $product['sku'];
                    $productCartFormat['weight'] = $product['weight'];
                    $productCartFormat['taxRate'] = $cartItem['taxRate'];
                    $productCartFormat['store_id'] = $cartItem['store_id'];
                    $productCartFormat['delivery'] = $cartItem['delivery'];
                    $productCartFormat['pickup'] = $cartItem['pickup'];

                    $productCartFormat['deldate'] = $cartItem['deldate'];
                    $productCartFormat['extras'] = [];

                    if (!$product || $product->original_product->status != BaseStatusEnum::PUBLISHED) {
                        $this->remove($cartItem['id']);
                    } else {
                        $productInCart = clone $product;
                        $productInCart->carts = $cartItem;
                        $productInCart->quantity = $cartItem['qty'];
                        $productInCart->formateCart = $productCartFormat;
                        $productsInCart->push($productInCart);
                        $weight += $product['weight'] * $cartItem['qty'];
                    }
                }
            }
        }

        $weight = EcommerceHelper::validateOrderWeight($weight);

        $resProducts = $productsInCart;
        $resWeight = $weight;

        return $resProducts;
    }

    public function getSignTerms(string $token)
    {
        $order = $this->orderRepository
            ->getModel()
            ->where('token', $token)
            ->with(['address', 'products'])
            ->orderBy('id', 'desc')
            ->first();

        if (!$order) {
            return 404;
        }

        $products = collect();

        $productsIds = $order->products->pluck('product_id')->all();

        $useProductTerms = false;
        $useGlobalTerms = false;

        if (!empty($productsIds)) {
            $products = get_products([
                'condition' => [['ec_products.id', 'IN', $productsIds]],
                'select' => ['ec_products.id', 'ec_products.images', 'ec_products.name', 'ec_products.price', 'ec_products.sale_price', 'ec_products.sale_type', 'ec_products.start_date', 'ec_products.end_date', 'ec_products.sku', 'ec_products.order', 'ec_products.created_at', 'ec_products.is_variation', 'ec_products.use_global', 'ec_products.terms_id'],
                'with' => ['variationProductAttributes'],
            ]);

            foreach ($products as $key => $product) {
                if ($product->terms_id) {
                    $term = Terms::where('id', $product->terms_id)
                        ->where('status', 'published')
                        ->first();
                    if ($term) {
                        $useProductTerms = true;
                    }
                }

                if ($useGlobalTerms == false && $product->use_global == 1) {
                    $useGlobalTerms = true;
                }
            }
        }

        return route('public.checkout.sign-terms', $token);
    }

    public function uploadLicense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:ec_orders,id',
            'file.*' => 'required|mimes:jpeg,png',
            'file' => 'required|array|size:2',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed',
                    'success' => false,
                ],
                422,
            );
        }

        $orderId = $request->order_id;
        $order = $this->orderRepository->findOrFail($orderId);
        $orderImgArr = json_decode($order->license_images, true) ?? [];
        if (count($orderImgArr) > 0) {
            $files = MediaFile::whereIn('url', $orderImgArr)->get();
            foreach ($files as $file) {
                $file->forceDelete();
            }
            $order->license_images = [];
            $order->save();
        }

        $objFolder = MediaFolder::where('name', 'License')->first();
        $folderId = $objFolder->id ?? 0;

        try {
            // We are in chunk mode, let's send the current progress
            $uploadedFiles = [];

            foreach ($request->file as $file) {
                $result = RvMedia::handleUpload($file, $folderId);
                if (!$result['error']) {
                    $uploadedFiles[] = $result['data']->url;
                } else {
                    return RvMedia::responseError($result['message']);
                }
            }

            // Save the file names to the order model
            $order->license_images = $uploadedFiles;
            $order->save();

            $uploadedFileUrl = [];
            foreach ($uploadedFiles as $key => $value) {
                $uploadedFileUrl[] = RvMedia::url($value);
            }
            return response()->json([
                'errors' => [],
                'message' => 'Files Uploaded Successfully.',
                'data' => $uploadedFileUrl,
                'success' => true,
            ]);
        } catch (Exception $exception) {
            return response()->json(
                [
                    'errors' => [],
                    'message' => $exception->getMessage(),
                    'data' => (object) [],
                    'success' => false,
                ],
                500,
            );
        }
    }

    public function removeLicense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:ec_orders,id',
            'file_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed',
                    'success' => false,
                ],
                422,
            );
        }

        $orderId = $request->order_id;
        $order = $this->orderRepository->findOrFail($orderId);
        $orderImgArr = json_decode($order->license_images, true) ?? [];

        $key = array_search($request->file_name, $orderImgArr);

        if ($key !== false) {
            unset($orderImgArr[$key]);
        }
        $order->license_images = $orderImgArr;
        $this->orderRepository->createOrUpdate($order);

        return response()->json([
            'errors' => [],
            'message' => 'File Removed Successfully.',
            'data' => (object) [],
            'success' => true,
        ]);
    }

    public function uploadImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:ec_orders,id',
            'file.*' => 'required',
            'file' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed',
                    'success' => false,
                ],
                422,
            );
        }

        $orderId = $request->order_id;
        $order = $this->orderRepository->findOrFail($orderId);
        $orderImgArr = json_decode($order->images, true) ?? [];
        // if (count($orderImgArr) > 0) {
        //     $files = MediaFile::whereIn('url', $orderImgArr)->get();
        //     foreach ($files as $file) {
        //         $file->forceDelete();
        //     }
        //     $order->images = [];
        //     $order->save();
        // }

        $objFolder = MediaFolder::where('name', 'Order Images')->first();
        $folderId = $objFolder->id ?? 0;

        try {
            // We are in chunk mode, let's send the current progress
            $uploadedFiles = $orderImgArr;

            foreach ($request->file as $file) {
                $result = RvMedia::handleUpload($file, $folderId);
                if (!$result['error']) {
                    $uploadedFiles[] = $result['data']->url;
                } else {
                    return RvMedia::responseError($result['message']);
                }
            }

            // Save the file names to the order model
            $order->images = $uploadedFiles;
            $order->save();

            $uploadedFileUrl = [];
            foreach ($uploadedFiles as $key => $value) {
                $uploadedFileUrl[] = RvMedia::url($value);
            }
            return response()->json([
                'errors' => [],
                'message' => 'Files Uploaded Successfully.',
                'data' => $uploadedFileUrl,
                'success' => true,
            ]);
        } catch (Exception $exception) {
            return response()->json(
                [
                    'errors' => [],
                    'message' => $exception->getMessage(),
                    'data' => (object) [],
                    'success' => false,
                ],
                500,
            );
        }
    }

    public function removeImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:ec_orders,id',
            'file_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed',
                    'success' => false,
                ],
                422,
            );
        }

        // Extract the path part after the '/storage/' segment
        $fileName = trim(str_replace(url('/storage/'), '', rtrim($request->file_name, '/')), '/');

        $orderId = $request->order_id;
        $order = $this->orderRepository->findOrFail($orderId);
        $orderImgArr = json_decode($order->images, true) ?? [];

        $key = array_search($fileName, $orderImgArr);

        if ($key === false) {
            return response()->json([
                'errors' => [],
                'message' => 'Image Not Found.',
                'data' => (object) [],
                'success' => false,
            ]);
        }
        if ($file = MediaFile::where('url', $orderImgArr[$key])->first()) {
            $file->forceDelete();
        }

        if ($key !== false) {
            unset($orderImgArr[$key]);
        }
        $order->images = json_encode($orderImgArr);
        $this->orderRepository->createOrUpdate($order);

        return response()->json(
            [
                'errors' => [],
                'message' => 'File Removed Successfully.',
                'data' => (object) [],
                'success' => true,
            ],
            200,
        );
    }

    // public function updateOrderProductHours(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'order_id' => 'required|exists:ec_orders,id',
    //         'product_id' => 'required|exists:ec_products,id',
    //         'start' => 'required',
    //         'allocated' => 'required',
    //         'end' => 'required',
    //         'total' => 'required',
    //         'over' => 'required',
    //         'over_rate' => 'required',
    //         'total_cost' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(
    //             [
    //                 'errors' => $validator->errors(),
    //                 'message' => 'Validation failed',
    //                 'success' => false,
    //             ],
    //             422,
    //         );
    //     }

    //     $data = $validator->validated();

    //     $orderProductMachineHours = $this->orderMachineHourRepository->createOrUpdate($data, [
    //         'order_id' => $data['order_id'],
    //         'product_id' => $data['product_id'],
    //     ]);

    //     if ($orderProductMachineHours) {
    //         return response()->json(
    //             [
    //                 'errors' => [],
    //                 'message' => 'Order Product Machine hours updated Successfully.',
    //                 'data' => $orderProductMachineHours,
    //                 'success' => true,
    //             ],
    //             200,
    //         );
    //     }

    //     return response()->json(
    //         [
    //             'errors' => [],
    //             'message' => 'Operation Fail.',
    //             'data' => (object) [],
    //             'success' => false,
    //         ],
    //         200,
    //     );
    // }

    public function updateOrderMultipleProductHours(Request $request)
    {
        // Define your validation rules
        $rules = [
            '*.order_id' => 'required|exists:ec_orders,id',
            '*.product_id' => 'required|exists:ec_products,id',
            '*.start' => 'required',
            '*.allocated' => 'required',
            '*.end' => 'required',
            '*.total' => 'required',
            '*.over' => 'required',
            '*.over_rate' => 'required',
            '*.total_cost' => 'required',
        ];

        // Run the validation
        $validator = Validator::make($request->all(), $rules);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
            // You can handle the validation failure according to your application's requirements.
        }

        $data = $validator->validated();
        $orderProductMachineHours = [];
        foreach ($data as $key => $item) {
            $orderProductMachineHours[] = $this->orderMachineHourRepository->createOrUpdate($item, [
                'order_id' => $item['order_id'],
                'product_id' => $item['product_id'],
            ]);
        }

        if (count($orderProductMachineHours) > 0) {
            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Order Product Machine hours updated Successfully.',
                    'data' => $orderProductMachineHours,
                    'success' => true,
                ],
                200,
            );
        }

        return response()->json(
            [
                'errors' => [],
                'message' => 'Operation Fail.',
                'data' => (object) [],
                'success' => false,
            ],
            200,
        );
    }

    public function orderPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:ec_orders,id',
            'card_number' => 'nullable',
            'mm_yy' => 'nullable',
            'cvc' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed',
                    'success' => false,
                ],
                422,
            );
        }
        $data = $validator->validated();

        $order = Order::where('id', $data['order_id'])->firstOrFail();

        $contactData = [
            'name' => $order->shippingAddress->name ?? null,
            'email' => $order->shippingAddress->email,
            'phone' => $order->shippingAddress->phone ?? null,
            'address' => $order->shippingAddress->address ?? null,
            'zipcode' => $order->shippingAddress->zip_code ?? null,
            'city' => $order->shippingAddress->city ?? null,
            'state' => $order->shippingAddress->state ?? null,
            'country' => $order->shippingAddress->country ?? null,
        ];

        $customer = $order->user;

        if ($order) {
            $chargeId = Str::upper(Str::random(10));
            $refId = 'rentalapp' . time();
            if (isset($data['card_number']) && !empty($data['card_number']) && isset($data['mm_yy']) && !empty($data['mm_yy']) && isset($data['cvc']) && !empty($data['cvc'])) {
                $responseData = [];
                $responseData['error'] = false;
                $responseData['message'] = '';

                // Set the customer's Bill To address
                $customerAddress = new AnetAPI\CustomerAddressType();
                $customerAddress->setFirstName($contactData['name'] ?? null);
                // $customerAddress->setLastName("Johnson");
                // $customerAddress->setCompany("Souveniropolis");
                $customerAddress->setAddress($contactData['address'] ?? null);
                $customerAddress->setCity($contactData['city'] ?? null);
                $customerAddress->setState($contactData['state'] ?? null);
                $customerAddress->setZip($contactData['zipcode'] ?? null);
                $customerAddress->setCountry($contactData['country'] ?? null);
                $customerAddress->setEmail($contactData['email'] ?? null);

                // Set the customer's identifying information
                $customerData = new AnetAPI\CustomerDataType();
                $customerData->setType('individual');
                $customerData->setId($customer->id ?? null);
                $customerData->setEmail($customer->email ?? ($contactData['email'] ?? null));

                // Create order information
                $orderType = new AnetAPI\OrderType();
                $orderType->setInvoiceNumber($order->code ?? null);
                // $order->setDescription("Golf Shirts");

                $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                $merchantAuthentication->setName(setting('payment_authorizenet_merchant_login_id'));
                $merchantAuthentication->setTransactionKey(setting('payment_authorizenet_merchant_transaction_key'));

                $cardNumber = preg_replace('/\s+/', '', $data['card_number']);
                $expiry = $data['mm_yy'];
                $expiryData = explode('/', $expiry);
                $expiration_month = $expiryData[0];
                $expiration_year = $expiryData[1];

                // Create the payment data for a credit card
                $creditCard = new AnetAPI\CreditCardType();
                $creditCard->setCardNumber($cardNumber);
                $creditCard->setExpirationDate('20' . $expiration_year . '-' . $expiration_month);
                $creditCard->setCardCode($data['cvc']);

                // Add the payment data to a paymentType object
                $paymentCreditCard = new AnetAPI\PaymentType();
                $paymentCreditCard->setCreditCard($creditCard);

                $shippingProfiles[] = $customerAddress;
                $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
                $paymentProfile->setCustomerType('individual');
                $paymentProfile->setBillTo($customerAddress);
                $paymentProfile->setPayment($paymentCreditCard);
                $paymentProfiles[] = $paymentProfile;

                // Create a new CustomerProfileType and add the payment profile object
                $customerProfile = new AnetAPI\CustomerProfileType();
                $customerProfile->setDescription('Customer Order Profile');
                // $customerProfile->setMerchantCustomerId("M_" . time());
                $customerProfile->setMerchantCustomerId('RA_' . time());
                $customerProfile->setEmail($customer->email ?? ($contactData['email'] ?? null));
                $customerProfile->setpaymentProfiles($paymentProfiles);
                $customerProfile->setShipToList($shippingProfiles);
                // dd($customerProfile);

                // Assemble the complete transaction request
                $customerProfileRequest = new AnetAPI\CreateCustomerProfileRequest();
                $customerProfileRequest->setMerchantAuthentication($merchantAuthentication);
                $customerProfileRequest->setRefId($refId);
                $customerProfileRequest->setProfile($customerProfile);

                // Create the controller and get the response
                $controller = new AnetController\CreateCustomerProfileController($customerProfileRequest);
                if (env('APP_ENV') == 'production') {
                    $cpResponse = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                } else {
                    $cpResponse = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
                }

                if ($cpResponse != null && $cpResponse->getMessages()->getResultCode() == 'Ok') {
                    // echo "Succesfully created customer profile : " . $cpResponse->getCustomerProfileId() . "\n";
                    $customerProfileId = $cpResponse->getCustomerProfileId();
                    $paymentProfiles = $cpResponse->getCustomerPaymentProfileIdList();
                    $paymentProfileId = $paymentProfiles[0];
                    $order->authorize_customer_id = $customerProfileId;
                    $order->authorize_customer_payment_id = $paymentProfileId;
                    $order->save();
                    // dd($orderDetails);
                } else {
                    // echo "ERROR :  Invalid response\n";
                    $errorMessages = $cpResponse->getMessages()->getMessage();
                    $errorMessage = $errorMessages[0]->getText();
                    // echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
                    // return redirect()->back()->withErrors(['error' => $errorMessages]);
                    $orderId = $order->id;
                    $responseData['error'] = true;
                    $responseData['message'] = $errorMessage;
                    if ($responseData['error'] == true) {
                        $paymentStatus = PaymentStatusEnum::FAILED;
                    }
                    $authorizenetPaymnetData = [
                        'amount' => $order->amount,
                        'currency' => cms_currency()->getDefaultCurrency()->title,
                        'charge_id' => $chargeId,
                        'order_id' => $order->id,
                        'customer_id' => $order->user_id,
                        'customer_type' => 'Botble\Ecommerce\Models\Customer',
                        'payment_channel' => AUTHORIZENET_PAYMENT_METHOD_NAME,
                        'status' => $paymentStatus,
                        'message' => $responseData['message'] ?? null,
                    ];
                    $sessionArr = ["authorizenetPaymnetData_$orderId" => $authorizenetPaymnetData];
                    return $responseData;
                }
            } else {
                if (
                    $oldOrder = Order::where('user_id', $order->user_id)
                        ->whereNotNull('authorize_customer_id')
                        ->first()
                ) {
                    $customerProfileId = $oldOrder->authorize_customer_id;
                    $paymentProfileId = $oldOrder->authorize_customer_payment_id;

                    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                    $merchantAuthentication->setName(setting('payment_authorizenet_merchant_login_id'));
                    $merchantAuthentication->setTransactionKey(setting('payment_authorizenet_merchant_transaction_key'));
                } else {
                    return response()->json(
                        [
                            'errors' => [],
                            'message' => 'Authorize Payment Details Not Found.',
                            'success' => false,
                        ],
                        404,
                    );
                }
            }
            $profileToCharge = new AnetAPI\CustomerProfilePaymentType();
            $profileToCharge->setCustomerProfileId($customerProfileId);
            $paymentProfile = new AnetAPI\PaymentProfileType();
            $paymentProfile->setPaymentProfileId($paymentProfileId);
            $profileToCharge->setPaymentProfile($paymentProfile);

            // Create a TransactionRequestType object and add the previous objects to it
            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType('authCaptureTransaction'); //authCaptureTransaction
            $transactionRequestType->setAmount($order->amount); // $order->amount
            // $transactionRequestType->setPayment($paymentCreditCard);
            $transactionRequestType->setProfile($profileToCharge);

            // $transactionRequestType->setOrder($order);
            // $transactionRequestType->setBillTo($customerAddress);
            // $transactionRequestType->setShipTo($customerAddress);
            // $transactionRequestType->setCustomer($customerData);

            // Assemble the complete transaction request
            $requests = new AnetAPI\CreateTransactionRequest();
            $requests->setMerchantAuthentication($merchantAuthentication);
            $requests->setRefId($refId);
            $requests->setTransactionRequest($transactionRequestType);

            // Create the controller and get the response
            $controller = new AnetController\CreateTransactionController($requests);
            if (env('APP_ENV') == 'production') {
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
            } else {
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
            }

            if ($response != null) {
                // Check to see if the API request was successfully received and acted upon
                if ($response->getMessages()->getResultCode() == 'Ok') {
                    // Since the API request was successful, look for a transaction response
                    // and parse it to display the results of authorizing the card
                    $tresponse = $response->getTransactionResponse();
                    // dd($tresponse);

                    if ($tresponse != null && $tresponse->getMessages() != null) {
                        // echo " Transaction Response code : " . $tresponse->getResponseCode() . "\n";
                        // echo "Charge Tokenized Credit Card AUTH CODE : " . $tresponse->getAuthCode() . "\n";
                        // echo "Charge Tokenized Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
                        // echo " Code : " . $tresponse->getMessages()[0]->getCode() . "\n";
                        // echo " Description : " . $tresponse->getMessages()[0]->getDescription() . "\n";
                        $message_text = $tresponse->getMessages()[0]->getDescription() . ', Transaction ID: ' . $tresponse->getTransId();
                        $msg_type = 'success_msg';
                        $responseData['error'] = false;
                        $responseData['message'] = $message_text;

                        /* \App\PaymentLogs::create([
                                'amount' => $input['amount'],
                                'response_code' => $tresponse->getResponseCode(),
                                'transaction_id' => $tresponse->getTransId(),
                                'auth_id' => $tresponse->getAuthCode(),
                                'message_code' => $tresponse->getMessages()[0]->getCode(),
                                'name_on_card' => trim($input['owner']),
                                'quantity'=>1
                            ]); */
                    } else {
                        $message_text = 'There were some issue with the payment. Please try again later.';
                        $msg_type = 'error_msg';
                        $responseData['error'] = true;
                        $responseData['message'] = $message_text;

                        if ($tresponse->getErrors() != null) {
                            $message_text = $tresponse->getErrors()[0]->getErrorText();
                            $msg_type = 'error_msg';
                            $responseData['error'] = true;
                            $responseData['message'] = $message_text;
                        }
                    }
                    // Or, print errors if the API request wasn't successful
                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = 'error_msg';
                    $responseData['error'] = true;
                    $responseData['message'] = $message_text;

                    $tresponse = $response->getTransactionResponse();

                    if ($tresponse != null && $tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = 'error_msg';
                        $responseData['error'] = true;
                        $responseData['message'] = $message_text;
                    } else {
                        $message_text = $response->getMessages()->getMessage()[0]->getText();
                        $msg_type = 'error_msg';
                        $responseData['error'] = true;
                        $responseData['message'] = $message_text;
                    }
                }

                $chargeId = $tresponse->getTransId() == 0 ? $refId : $tresponse->getTransId();
            } else {
                $chargeId = $refId;
                $message_text = 'No response returned';
                $msg_type = 'error_msg';
                $responseData['error'] = true;
                $responseData['message'] = $message_text;
            }
            $chargeId = $chargeId ?? $refId;
            $orderId = $order->id;
            $paymentStatus = PaymentStatusEnum::COMPLETED;
            if ($responseData['error'] == true) {
                $paymentStatus = PaymentStatusEnum::FAILED;
            }
            $authorizenetPaymnetData = [
                'amount' => $order->amount,
                'currency' => cms_currency()->getDefaultCurrency()->title,
                'charge_id' => $chargeId,
                'order_id' => $order->id,
                'customer_id' => $order->user_id,
                'customer_type' => 'Botble\Ecommerce\Models\Customer',
                'payment_channel' => AUTHORIZENET_PAYMENT_METHOD_NAME,
                'status' => $paymentStatus,
                'message' => $responseData['message'] ?? null,
            ];
            if ($responseData['error'] == true) {
                return $responseData;
            }

            $payment = app(PaymentInterface::class)->createOrUpdate($authorizenetPaymnetData);

            $order->payment_id = $payment->id;
            $order->save();

            return response()->json(
                [
                    'errors' => [],
                    'success' => true,
                    'message' => 'Order payment successfully done.',
                    'data' => $order,
                ],
                200,
            );
        }

        return response()->json(
            [
                'errors' => [],
                'success' => false,
                'message' => 'Order not found.',
            ],
            404,
        );
    }
    # place order api end

    public function getStores()
    {
        $storeLocators = $this->storeLocatorRepository->all();

        if (count($storeLocators) > 0) {
            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Stores successfully Found.',
                    'data' => $storeLocators,
                    'success' => true,
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Stores not found.',
                    'data' => (object) [],
                    'success' => false,
                ],
                404,
            );
        }
    }

    public function getDeliveryPickUpList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|in:1,2', // 1 pending , 2 completed
            'type' => 'nullable|in:Delivery,Pickup',
            'limit' => 'nullable',
            'page' => 'nullable'

            // 'delivery_status' => 'nullable|in:1,2',
            // 'pickup_status' => 'nullable|in:1,2',
        ]);


        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed',
                    'success' => false,
                ],
                422,
            );
        }

        $data = $validator->validated();

        $limit = $data['limit'] ?? 10;
        $page = $data['page'] ?? 1;

        $objDeliveryPickUp = DeliveryPickup::with('order','order.products')->whereHas('order.payment', function ($query)  {
            $query->whereIn('status', ["pending","completed"]);
        });

        // if (isset($data['delivery_status']) && !empty($data['delivery_status'])) {
        //     $objDeliveryPickUp->where('delivery_status', $data['delivery_status']);
        // }

        // if (isset($data['pickup_status']) && !empty($data['pickup_status'])) {
        //     $objDeliveryPickUp->where('pickup_status', $data['pickup_status']);
        // }

        if (isset($data['type']) && !empty($data['type'])) {
            if ($data['type'] == "Delivery") {
                // $objDeliveryPickUp->where('customer_delivery', 2);
                if (isset($data['status']) && !empty($data['status'])) {

                    if ($data['status'] == 1) {
                        $objDeliveryPickUp->where('delivery_status', $data['status']);
                        $objDeliveryPickUp->whereDate('delivery_date', '>=', now()->format('Y-m-d'))->orderBy('delivery_date','asc');
                    }

                    if ($data['status'] == 2) {
                        $objDeliveryPickUp->where(function ($query) use ($data) {
                            $query->where(function ($query) {
                                $query->whereDate('delivery_date', '<', now()->format('Y-m-d'));
                            })->orWhere(function ($query) use ($data) {
                                $query->whereDate('delivery_date', '>=', now()->format('Y-m-d'))
                                      ->where('delivery_status', $data['status']);
                            });
                        })
                        ->orderBy('delivery_date', 'desc');
                    }
                }
            }

            if ($data['type'] == "Pickup") {
                // $objDeliveryPickUp->where('customer_pickup', 2);
                if (isset($data['status']) && !empty($data['status'])) {

                    if ($data['status'] == 1) {
                        $objDeliveryPickUp->where('pickup_status', $data['status']);
                        $objDeliveryPickUp->whereDate('pickup_date', '>=', now()->format('Y-m-d'))->orderBy('pickup_date','asc');
                    }
                    if ($data['status'] == 2) {
                        $objDeliveryPickUp->where(function ($query) use ($data) {
                            $query->where(function ($query) {
                                $query->whereDate('pickup_date', '<', now()->format('Y-m-d'));
                            })->orWhere(function ($query) use ($data) {
                                $query->whereDate('pickup_date', '>=', now()->format('Y-m-d'))
                                      ->where('pickup_status', $data['status']);
                            });
                        })
                        ->orderBy('pickup_date', 'desc');
                    }
                }
            }
        }


        // if (isset($data['pickup_status']) && !empty($data['pickup_status'])) {
        //     $objDeliveryPickUp->where('pickup_status', $data['pickup_status']);
        // }

        $deliveryPickUpData = $objDeliveryPickUp->orderBy('delivery_date')->orderBy('pickup_date')->orderBy('delivery_status')
        ->orderBy('pickup_status')->paginate($limit, ['*'], 'page', $page);

        // $deliveryPickUpData = DeliveryPickup::with('order','order.products')->where('delivery_status', DeliveryStatusEnum::PENDING()->getValue())->where('pickup_status', DeliveryStatusEnum::PENDING()->getValue())->orderBy('delivery_date')->orderBy('pickup_date')->get();
        if (count($deliveryPickUpData) > 0) {
            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Data Found.',
                    'data' => $deliveryPickUpData,
                    'success' => true,
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Data not found.',
                    'data' => (object) [],
                    'success' => true,
                ],
                200,
            );
        }
    }

    public function getDeliveryPickUpCount(Request $request)
    {
        $objPendingDeliveryCount = DeliveryPickup::whereHas('order.payment', function ($query)  {
            $query->whereIn('status', ["pending","completed"]);
        })->where('delivery_status', "1")->whereDate('delivery_date', '>=', now()->format('Y-m-d'))->count();
        $objPendingPickUpCount = DeliveryPickup::whereHas('order.payment', function ($query)  {
            $query->whereIn('status', ["pending","completed"]);
        })->where('pickup_status', "1")->whereDate('pickup_date', '>=', now()->format('Y-m-d'))->count();
        $objPastPendingDeliveryCount = DeliveryPickup::whereHas('order.payment', function ($query)  {
            $query->whereIn('status', ["pending","completed"]);
        })->where('delivery_status', "1")->whereDate('delivery_date', '<', now()->format('Y-m-d'))->count();
        $objPastPendingPickupCount = DeliveryPickup::whereHas('order.payment', function ($query)  {
            $query->whereIn('status', ["pending","completed"]);
        })->where('pickup_status', "1")->whereDate('pickup_date', '<', now()->format('Y-m-d'))->count();

        return response()->json(
            [
                'errors' => [],
                'message' => 'Data Found.',
                'data' => [
                    "pendingDeliveryCount"=>$objPendingDeliveryCount,
                    "pendingPickupCount"=>$objPendingPickUpCount,
                    "pastPendingDeliveryCount"=>$objPastPendingDeliveryCount,
                    "pastPendingPickupCount"=>$objPastPendingPickupCount,
                ],
                'success' => true,
            ],
            200,
        );
    }

    public function updateDeliveryPickUpStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:ec_delivery_pickup,id',
            'delivery_status' => 'nullable',
            'pickup_status' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed',
                    'success' => false,
                ],
                422,
            );
        }
        $data = $validator->validated();

        $deliveryPickUpData = DeliveryPickup::findOrFail($data['id']);

        if ($deliveryPickUpData) {
            if (isset($data['delivery_status'])) {
                $deliveryPickUpData->delivery_status = $data['delivery_status'];
            }

            if (isset($data['pickup_status'])) {
                $deliveryPickUpData->pickup_status = $data['pickup_status'];
            }
            $deliveryPickUpData->save();

            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Record Updated.',
                    'data' => $deliveryPickUpData,
                    'success' => true,
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Record not found.',
                    'data' => (object) [],
                    'success' => false,
                ],
                404,
            );
        }
    }

    public function orderNotUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:ec_orders,id',
            'order_note' => 'nullable',
            'delivery_note' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed',
                    'success' => false,
                ],
                422,
            );
        }
        $data = $validator->validated();


        $orderData = Order::where('id',$data['order_id'])->firstOrFail();

        if ($orderData) {
            if (isset($data['order_note'])) {
                $orderData->description = $data['order_note'];
                $orderData->save();
            }

            $deliveryOrderData = DeliveryPickup::where('order_id',$data['order_id'])->firstOrFail();
            if (isset($data['delivery_note'])) {
                $deliveryOrderData->comment = $data['delivery_note'];
                $deliveryOrderData->save();
            }

            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Notes Updated.',
                    'success' => true,
                    'data' => (object) [],
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Order not found.',
                    'data' => (object) [],
                    'success' => false,
                ],
                404,
            );
        }
    }

    public function orderAddressUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:ec_order_addresses,id',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip_code' => 'nullable',
            'country' => 'nullable',
            'address' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed',
                    'success' => false,
                ],
                422,
            );
        }
        $data = $validator->validated();

        $orderAddress = OrderAddress::where('id',$data['address_id'])->firstOrFail();


        if ($orderAddress) {
            $orderAddress->name = $data['name'] ?? null;
            $orderAddress->phone = $data['phone'] ?? null;
            $orderAddress->email = $data['email'] ?? null;
            $orderAddress->state = $data['state'] ?? null;
            $orderAddress->city = $data['city'] ?? null;
            $orderAddress->zip_code = $data['zip_code'] ?? null;
            $orderAddress->country = $data['country'] ?? null;
            $orderAddress->address = $data['address'] ?? null;
            $orderAddress->save();

            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Address Updated.',
                    'data' => $orderAddress,
                    'success' => true,
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'errors' => [],
                    'message' => 'Address not found.',
                    'data' => (object) [],
                    'success' => false,
                ],
                404,
            );
        }
    }
}
