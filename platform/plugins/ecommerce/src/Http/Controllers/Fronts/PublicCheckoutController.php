<?php

namespace Botble\Ecommerce\Http\Controllers\Fronts;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Enums\DeliveryStatusEnum;
use Botble\Ecommerce\Enums\DeliveryTypeEnum;
use Botble\Ecommerce\Enums\OrderStatusEnum;
use Botble\Ecommerce\Enums\ShippingCodStatusEnum;
use Botble\Ecommerce\Enums\ShippingMethodEnum;
use Botble\Ecommerce\Enums\ShippingStatusEnum;
use Botble\Ecommerce\Facades\Discount;
use Botble\Ecommerce\Http\Requests\ApplyCouponRequest;
use Botble\Ecommerce\Http\Requests\CheckoutRequest;
use Botble\Ecommerce\Http\Requests\SaveCheckoutInformationRequest;
use Botble\Ecommerce\Models\Order;
use Botble\Ecommerce\Repositories\Interfaces\AddressInterface;
use Botble\Ecommerce\Repositories\Interfaces\CustomerInterface;
use Botble\Ecommerce\Repositories\Interfaces\DiscountInterface;
use Botble\Ecommerce\Repositories\Interfaces\OrderAddressInterface;
use Botble\Ecommerce\Repositories\Interfaces\OrderHistoryInterface;
use Botble\Ecommerce\Repositories\Interfaces\OrderInterface;
use Botble\Ecommerce\Repositories\Interfaces\OrderMachineHourInterface;
use Botble\Ecommerce\Repositories\Interfaces\DeliveryPickUpInterface;
use Botble\Ecommerce\Repositories\Interfaces\OrderProductInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Ecommerce\Repositories\Interfaces\ShipmentInterface;
use Botble\Ecommerce\Repositories\Interfaces\ShippingInterface;
use Botble\Ecommerce\Repositories\Interfaces\TaxInterface;
use Botble\Ecommerce\Services\Footprints\FootprinterInterface;
use Botble\Ecommerce\Services\HandleApplyCouponService;
use Botble\Ecommerce\Services\HandleApplyPromotionsService;
use Botble\Ecommerce\Services\HandleRemoveCouponService;
use Botble\Ecommerce\Services\HandleShippingFeeService;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Supports\PaymentHelper;
use Botble\Ecommerce\Facades\Cart;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Botble\Optimize\Facades\OptimizerHelper;
use Botble\Ecommerce\Facades\OrderHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Validator;
use Botble\Terms\Models\Terms;
use Botble\Contact\Models\Contact;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use DateTime;

class PublicCheckoutController
{
    public function __construct(
        protected TaxInterface $taxRepository,
        protected OrderInterface $orderRepository,
        protected OrderProductInterface $orderProductRepository,
        protected OrderMachineHourInterface $orderMachineHourRepository,
        protected OrderAddressInterface $orderAddressRepository,
        protected AddressInterface $addressRepository,
        protected CustomerInterface $customerRepository,
        protected ShippingInterface $shippingRepository,
        protected OrderHistoryInterface $orderHistoryRepository,
        protected ProductInterface $productRepository,
        protected DiscountInterface $discountRepository,
        protected DeliveryPickUpInterface $deliveryPickUpRepository
    ) {
        OptimizerHelper::disable();
    }

    public function getCheckout(
        string $token,
        Request $request,
        BaseHttpResponse $response,
        HandleShippingFeeService $shippingFeeService,
        HandleApplyCouponService $applyCouponService,
        HandleRemoveCouponService $removeCouponService,
        HandleApplyPromotionsService $applyPromotionsService
    ) {
        if (! EcommerceHelper::isCartEnabled()) {
            abort(404);
        }

        if (! EcommerceHelper::isEnabledGuestCheckout() && ! auth('customer')->check()) {
            return $response->setNextUrl(route('customer.login'));
        }

        if ($token !== session('tracked_start_checkout')) {
            $order = $this->orderRepository->getFirstBy(['token' => $token, 'is_finished' => false]);

            if (! $order) {
                return $response->setNextUrl(route('public.index'));
            }
        }

        if (! $request->session()->has('error_msg') && $request->input('error') == 1 && $request->input('error_type') == 'payment') {
            $request->session()->flash('error_msg', __('Payment failed!'));
        }

        $sessionCheckoutData = OrderHelper::getOrderSessionData($token);

        $products = Cart::instance('cart')->products();

        if (! $products->count()) {
            if (session()->has('error_msg')) {
                return $response->setError()->setNextUrl(route('public.cart'))->setMessage(session('error_msg'));
            } else {
                return $response->setNextUrl(route('public.cart'));
            }
        }

        foreach ($products as $product) {
            if ($product->isOutOfStock()) {
                return $response
                    ->setError()
                    ->setNextUrl(route('public.cart'))
                    ->setMessage(__('Product :product is out of stock!', ['product' => $product->original_product->name]));
            }
        }

        if (EcommerceHelper::isEnabledSupportDigitalProducts() && ! EcommerceHelper::canCheckoutForDigitalProducts($products)) {
            return $response
                ->setError()
                ->setNextUrl(route('customer.login'))
                ->setMessage(__('Your shopping cart has digital product(s), so you need to sign in to continue!'));
        }

        $sessionCheckoutData = $this->processOrderData($token, $sessionCheckoutData, $request);

        $paymentMethod = null;

        if (is_plugin_active('payment')) {
            $paymentMethod = $request->input('payment_method', session('selected_payment_method') ?: PaymentHelper::defaultPaymentMethod());
        }

        if ($paymentMethod) {
            session()->put('selected_payment_method', $paymentMethod);
        }

        if (is_plugin_active('marketplace')) {
            [
                $sessionCheckoutData,
                $shipping,
                $defaultShippingMethod,
                $defaultShippingOption,
                $shippingAmount,
                $promotionDiscountAmount,
                $couponDiscountAmount,
            ] = apply_filters(PROCESS_CHECKOUT_ORDER_DATA_ECOMMERCE, $products, $token, $sessionCheckoutData, $request);
        } else {
            $promotionDiscountAmount = $applyPromotionsService->execute($token);

            $sessionCheckoutData['promotion_discount_amount'] = $promotionDiscountAmount;

            $couponDiscountAmount = 0;
            if (session()->has('applied_coupon_code')) {
                $couponDiscountAmount = Arr::get($sessionCheckoutData, 'coupon_discount_amount', 0);
            }

            $orderTotal = Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount;
            $orderTotal = max($orderTotal, 0);

            $isAvailableShipping = EcommerceHelper::isAvailableShipping($products);

            $shipping = [];
            $defaultShippingMethod = $request->input('shipping_method', Arr::get($sessionCheckoutData, 'shipping_method', ShippingMethodEnum::DEFAULT));
            $defaultShippingOption = $request->input('shipping_option', Arr::get($sessionCheckoutData, 'shipping_option'));
            $shippingAmount = 0;

            if ($isAvailableShipping) {
                $origin = EcommerceHelper::getOriginAddress();
                $shippingData = EcommerceHelper::getShippingData($products, $sessionCheckoutData, $origin, $orderTotal, $paymentMethod);

                $shipping = $shippingFeeService->execute($shippingData);

                foreach ($shipping as $key => &$shipItem) {
                    if (get_shipping_setting('free_ship', $key)) {
                        foreach ($shipItem as &$subShippingItem) {
                            Arr::set($subShippingItem, 'price', 0);
                        }
                    }
                }

                if ($shipping) {
                    if (! $defaultShippingMethod) {
                        $defaultShippingMethod = old(
                            'shipping_method',
                            Arr::get($sessionCheckoutData, 'shipping_method', Arr::first(array_keys($shipping)))
                        );
                    }
                    if (! $defaultShippingOption) {
                        $defaultShippingOption = old('shipping_option', Arr::get($sessionCheckoutData, 'shipping_option', $defaultShippingOption));
                    }
                }

                $shippingAmount = Arr::get($shipping, $defaultShippingMethod . '.' . $defaultShippingOption . '.price', 0);

                Arr::set($sessionCheckoutData, 'shipping_method', $defaultShippingMethod);
                Arr::set($sessionCheckoutData, 'shipping_option', $defaultShippingOption);
                Arr::set($sessionCheckoutData, 'shipping_amount', $shippingAmount);

                OrderHelper::setOrderSessionData($token, $sessionCheckoutData);
            }

            if (session()->has('applied_coupon_code')) {
                if (! $request->input('applied_coupon')) {
                    $discount = $applyCouponService->getCouponData(
                        session('applied_coupon_code'),
                        $sessionCheckoutData
                    );
                    if (empty($discount)) {
                        $removeCouponService->execute();
                    } else {
                        $shippingAmount = Arr::get($sessionCheckoutData, 'is_free_shipping') ? 0 : $shippingAmount;
                    }
                } else {
                    $shippingAmount = Arr::get($sessionCheckoutData, 'is_free_shipping') ? 0 : $shippingAmount;
                }
            }

            $sessionCheckoutData['is_available_shipping'] = $isAvailableShipping;

            if (! $sessionCheckoutData['is_available_shipping']) {
                $shippingAmount = 0;
            }
        }

        $isShowAddressForm = EcommerceHelper::isSaveOrderShippingAddress($products);

        $data = compact(
            'token',
            'shipping',
            'defaultShippingMethod',
            'defaultShippingOption',
            'shippingAmount',
            'promotionDiscountAmount',
            'couponDiscountAmount',
            'sessionCheckoutData',
            'products',
            'isShowAddressForm',
        );

        if (auth('customer')->check()) {
            $addresses = auth('customer')->user()->addresses;
            $isAvailableAddress = ! $addresses->isEmpty();

            if (Arr::get($sessionCheckoutData, 'is_new_address')) {
                $sessionAddressId = 'new';
            } else {
                $sessionAddressId = Arr::get($sessionCheckoutData, 'address_id', $isAvailableAddress ? $addresses->first()->id : null);
                if (! $sessionAddressId && $isAvailableAddress) {
                    $address = $addresses->firstWhere('is_default') ?: $addresses->first();
                    $sessionAddressId = $address->id;
                }
            }

            $data = array_merge($data, compact('addresses', 'isAvailableAddress', 'sessionAddressId'));
        }

        $checkoutView = Theme::getThemeNamespace('views.ecommerce.orders.checkout');

        if (view()->exists($checkoutView)) {
            return view($checkoutView, $data);
        }

        return view('plugins/ecommerce::orders.checkout', $data);
    }

    protected function processOrderData(string $token, array $sessionData, Request $request, bool $finished = false): array
    {

        if ($request->has('billing_address_same_as_shipping_address')) {
            $sessionData['billing_address_same_as_shipping_address'] = $request->input('billing_address_same_as_shipping_address');
        }

        if ($request->has('billing_address')) {
            $sessionData['billing_address'] = $request->input('billing_address');
        }

        if ($request->has('address.address_id')) {
            $sessionData['is_new_address'] = $request->input('address.address_id') == 'new';
        }

        if ($request->input('address', [])) {
            // check only if the user check register option
//            if (! isset($sessionData['created_account']) && $request->input('create_account') == 1) {
            if ($request->input('create_account') == 1) {
                $validator = Validator::make($request->input(), [
                    'password' => 'required|min:6',
                    'password_confirmation' => 'required|same:password',
//                    'address.email' => 'required|max:60|min:6|email|unique:ec_customers,email,Customer,type',
                    'address.email' => ['required','max:60', 'min:6','email', Rule::unique('ec_customers', 'email')->where(function ($query) {
                        return $query->where('type', 'Customer');
                    })],
                    'address.first_name' => 'required|min:3|max:120',
                    'address.last_name' => 'required|min:3|max:120',
                ]);

                if (! $validator->fails()) {
                    $customer = $this->customerRepository->createOrUpdate([
                        'name' => BaseHelper::clean($request->input('address.name')),
                        'email' => BaseHelper::clean($request->input('address.email')),
                        'phone' => BaseHelper::clean($request->input('address.phone')),
                        'password' => Hash::make($request->input('password')),
                        'type' => "Customer",
                    ], ['email' => BaseHelper::clean($request->input('address.email'))]);

                    auth('customer')->attempt([
                        'email' => $request->input('address.email'),
                        'password' => $request->input('password'),
                    ], true);
                    //dd($customer);
                    event(new Registered($customer));

                    $sessionData['created_account'] = true;

                    $address = $this->addressRepository
                        ->createOrUpdate(array_merge($request->input('address'), [
                            'customer_id' => $customer->id,
                            'is_default' => true,
                        ]));

                    $request->merge(['address.address_id' => $address->id]);
                    $sessionData['address_id'] = $address->id;
                }
            }else{
                if (!auth('customer')->check()) {
                    $customer = $this->customerRepository->createOrUpdate([
                        'name' => BaseHelper::clean($request->input('address.name')),
                        'email' => BaseHelper::clean($request->input('address.email')),
                        'phone' => BaseHelper::clean($request->input('address.phone')),
                        'password' => Hash::make($request->input('address.name')."@123"),
                        'type' => "Guest",
                    ], ['email' => BaseHelper::clean($request->input('address.email'))]);

                    // if the user try as guest, the password is name + @123
                    auth('customer')->login($customer);

                    event(new Registered($customer));

                    $sessionData['created_account'] = true;

                    $address = $this->addressRepository
                        ->createOrUpdate(array_merge($request->input('address'), [
                            'customer_id' => $customer->id,
                            'is_default' => true,
                        ]));

                    $request->merge(['address.address_id' => $address->id]);
                    $sessionData['address_id'] = $address->id;
                }
            }

            if ($finished && auth('customer')->check()) {
                $customer = auth('customer')->user();
                if ($customer->addresses->count() == 0 || $request->input('address.address_id') == 'new') {
                    $address = $this->addressRepository
                        ->createOrUpdate(array_merge($request->input('address', []), [
                            'customer_id' => auth('customer')->id(),
                            'is_default' => $customer->addresses->count() == 0,
                        ]));

                    $request->merge(['address.address_id' => $address->id]);
                    $sessionData['address_id'] = $address->id;
                }
            }
        }

        $address = null;

        if (($addressId = $request->input('address.address_id')) && $addressId !== 'new') {
            $address = $this->addressRepository->findById($addressId);
            if ($address) {
                $sessionData['address_id'] = $address->id;
            }
        } elseif (auth('customer')->check() && ! Arr::get($sessionData, 'address_id')) {
            $address = $this->addressRepository->getFirstBy([
                'customer_id' => auth('customer')->id(),
                'is_default' => true,
            ]);

            if ($address) {
                $sessionData['address_id'] = $address->id;
            }
        }

        $addressData = [
            'billing_address_same_as_shipping_address' => Arr::get($sessionData, 'billing_address_same_as_shipping_address', true),
            'billing_address' => Arr::get($sessionData, 'billing_address', []),
        ];

        if (! empty($address)) {
            $addressData = [
                'name' => $address->name,
                'phone' => $address->phone,
                'email' => $address->email,
                'country' => $address->country,
                'state' => $address->state,
                'city' => $address->city,
                'address' => $address->address,
                'zip_code' => $address->zip_code,
                'address_id' => $address->id,
            ];
        } elseif ((array)$request->input('address', [])) {
            $addressData = (array)$request->input('address', []);
        }


        $addressData = OrderHelper::cleanData($addressData);
        $sessionData = array_merge($sessionData, $addressData);


        $products = Cart::instance('cart')->products();
        if (is_plugin_active('marketplace')) {
            $sessionData = apply_filters(
                HANDLE_PROCESS_ORDER_DATA_ECOMMERCE,
                $products,
                $token,
                $sessionData,
                $request
            );

            OrderHelper::setOrderSessionData($token, $sessionData);

            return $sessionData;
        }

        if (! isset($sessionData['created_order'])) {
            $currentUserId = 0;
            if (auth('customer')->check()) {
                $currentUserId = auth('customer')->id();
            }

            $request->merge([
                'amount' => Cart::instance('cart')->rawTotal(),
                'user_id' => $currentUserId,
                'shipping_method' => $request->input('shipping_method', ShippingMethodEnum::DEFAULT),
                'shipping_option' => $request->input('shipping_option'),
                'shipping_amount' => 0,
                'tax_amount' => Cart::instance('cart')->rawTax(),
                'sub_total' => Cart::instance('cart')->rawSubTotal(),
                'coupon_code' => session()->get('applied_coupon_code'),
                'discount_amount' => 0,
                'status' => OrderStatusEnum::PENDING,
                'is_finished' => false,
                'token' => $token,
            ]);

            $order = $this->orderRepository->getFirstBy(compact('token'));

            $order = $this->createOrderFromData($request->input(), $order);

            $sessionData['created_order'] = true;
            $sessionData['created_order_id'] = $order->id;
        }

        if (! empty($address)) {
            $addressData['order_id'] = $sessionData['created_order_id'];
        } elseif ((array)$request->input('address', [])) {
            $addressData = array_merge(
                ['order_id' => $sessionData['created_order_id']],
                (array)$request->input('address', [])
            );
        }

        $sessionData['is_save_order_shipping_address'] = EcommerceHelper::isSaveOrderShippingAddress($products);
        $sessionData = OrderHelper::checkAndCreateOrderAddress($addressData, $sessionData);
       //dd($addressData);

        if (! isset($sessionData['created_order_product'])) {
            $weight = 0;
            foreach (Cart::instance('cart')->content() as $cartItem) {
                $product = $this->productRepository->findById($cartItem->id);
                if ($product && $product->weight) {
                    $weight += $product->weight * $cartItem->qty;
                }
            }

            $weight = EcommerceHelper::validateOrderWeight($weight);

            $this->orderProductRepository->deleteBy(['order_id' => $sessionData['created_order_id']]);

            foreach (Cart::instance('cart')->content() as $cartItem) {
                $product = $this->productRepository->findById($cartItem->id);

                $data = [
                    'order_id' => $sessionData['created_order_id'],
                    'product_id' => $cartItem->id,
                    'product_name' => $cartItem->name,
                    'product_image' => $product->original_product->image,
                    'qty' => $cartItem->qty,
                    'weight' => $weight,
                    'price' => $cartItem->price,
                    'tax_amount' => $cartItem->tax,
                    'options' => $cartItem->options,
                    'product_type' => $product ? $product->product_type : null,
                ];

                if ($cartItem->options['options']) {
                    $data['product_options'] = $cartItem->options['options'];
                }

                $this->orderProductRepository->create($data);

                // add order_machine_hour
                $allocated = 0;
                if ($product->rental_type != 0 && $product->hour_track == 1) {
                    if ($product->rental_type == RENTAL_TYPE_DAILY) {
                        $allocated = get_ecommerce_setting('daily_hours') * $cartItem->qty;
                    } else if ($product->rental_type == RENTAL_TYPE_WEEKEND) {
                        $allocated = get_ecommerce_setting('weekend_hours') * $cartItem->qty;
                    } else if ($product->rental_type == RENTAL_TYPE_WEEKLY) {
                        $allocated = get_ecommerce_setting('weekly_hours') * $cartItem->qty;
                    } else if ($product->rental_type == RENTAL_TYPE_MONTHLY) {
                        $allocated = get_ecommerce_setting('monthly_hours') * $cartItem->qty;
                    }
                }

                $data = [
                    'order_id' => $sessionData['created_order_id'],
                    'product_id' => $cartItem->id,
                    'start' => 0,
                    'end' => 0,
                    'allocated' => $allocated,
                    'over' => 0,
                    'over_rate' => $product->over_rate,
                    'total' => 0,
                    'total_cost' => 0,
                ];

                $this->orderMachineHourRepository->create($data);
            }

            $sessionData['created_order_product'] = Cart::instance('cart')->getLastUpdatedAt();
        }

        OrderHelper::setOrderSessionData($token, $sessionData);
        //dd($sessionData);
        return $sessionData;
    }

    public function postSaveInformation(
        string $token,
        SaveCheckoutInformationRequest $request,
        BaseHttpResponse $response,
        HandleApplyCouponService $applyCouponService,
        HandleRemoveCouponService $removeCouponService
    ) {
        if (! EcommerceHelper::isCartEnabled()) {
            abort(404);
        }

        if ($token !== session('tracked_start_checkout')) {
            $order = $this->orderRepository->getFirstBy(['token' => $token, 'is_finished' => false]);

            if (! $order) {
                return $response->setNextUrl(route('public.index'));
            }
        }

        if ($paymentMethod = $request->input('payment_method')) {
            session()->put('selected_payment_method', $paymentMethod);
        }

        if (is_plugin_active('marketplace')) {
            $sessionData = array_merge(OrderHelper::getOrderSessionData($token), $request->input('address'));

            $sessionData = apply_filters(
                PROCESS_POST_SAVE_INFORMATION_CHECKOUT_ECOMMERCE,
                $sessionData,
                $request,
                $token
            );
        } else {
            $sessionData = array_merge(OrderHelper::getOrderSessionData($token), $request->input('address'));
            OrderHelper::setOrderSessionData($token, $sessionData);
            if (session()->has('applied_coupon_code')) {
                $discount = $applyCouponService->getCouponData(session('applied_coupon_code'), $sessionData);
                if (! $discount) {
                    $removeCouponService->execute();
                }
            }
        }

        $sessionData = $this->processOrderData($token, $sessionData, $request);

        return $response->setData($sessionData);
    }

    public function postCheckout(
        string $token,
        CheckoutRequest $request,
        BaseHttpResponse $response,
        HandleShippingFeeService $shippingFeeService,
        HandleApplyCouponService $applyCouponService,
        HandleRemoveCouponService $removeCouponService,
        HandleApplyPromotionsService $handleApplyPromotionsService
    ) {
        if (! EcommerceHelper::isCartEnabled()) {
            abort(404);
        }
        if (! EcommerceHelper::isEnabledGuestCheckout() && ! auth('customer')->check()) {
            return $response->setNextUrl(route('customer.login'));
        }

        if (! Cart::instance('cart')->count()) {
            return $response
                ->setError()
                ->setMessage(__('No products in cart'));
        }
        $requestArr = $request->all();
        if (auth('customer')->check()) {
            $primaryEmail = auth('customer')->user()->email;
        }else{
            $primaryEmail = $requestArr['address']['email'] ?? null;
        }
        $contactData = [
            'first_name' => $requestArr['address']['first_name'] ?? null,
            'last_name' => $requestArr['address']['last_name'] ?? null,
            'name' => $requestArr['address']['name'] ?? null,
            'email' => $primaryEmail,
            'phone' => $requestArr['address']['phone'] ?? null,
            'address' => $requestArr['address']['address'] ?? null,
            'zipcode' => $requestArr['address']['zip_code'] ?? null,
            'city' => $requestArr['address']['city'] ?? null,
            'state' => $requestArr['address']['state'] ?? null,
            'country' => $requestArr['address']['country'] ?? null,
            'note' => $requestArr['description'] ?? null,
            'same_as_delivery'=>$requestArr['billing_address_same_as_shipping_address'],
            'first_name_d' => ($requestArr['billing_address_same_as_shipping_address'] == 0) ? ($requestArr['billing_address']['first_name'] ?? null) : ($requestArr['address']['first_name'] ?? null),
            'last_name_d' => ($requestArr['billing_address_same_as_shipping_address'] == 0) ? ($requestArr['billing_address']['last_name'] ?? null) : ($requestArr['address']['last_name'] ?? null),
            'delivery_email' => ($requestArr['billing_address_same_as_shipping_address'] == 0) ? ($requestArr['billing_address']['email'] ?? null) : ($requestArr['address']['email'] ?? null),
            'mobile_d' => ($requestArr['billing_address_same_as_shipping_address'] == 0) ? ($requestArr['billing_address']['phone'] ?? null) : ($requestArr['address']['phone'] ?? null),
            'delivery_address' => ($requestArr['billing_address_same_as_shipping_address'] == 0) ? ($requestArr['billing_address']['address'] ?? null) : ($requestArr['address']['address'] ?? null),
            'delivery_zipcode' => ($requestArr['billing_address_same_as_shipping_address'] == 0) ? ($requestArr['billing_address']['zip_code'] ?? null) : ($requestArr['address']['zip_code'] ?? null),
            'delivery_city' => ($requestArr['billing_address_same_as_shipping_address'] == 0) ? ($requestArr['billing_address']['city'] ?? null) : ($requestArr['address']['city'] ?? null),
            'delivery_state' => ($requestArr['billing_address_same_as_shipping_address'] == 0) ? ($requestArr['billing_address']['state'] ?? null) : ($requestArr['address']['state'] ?? null),
            'delivery_country' => ($requestArr['billing_address_same_as_shipping_address'] == 0) ? ($requestArr['billing_address']['country'] ?? null) : ($requestArr['address']['country'] ?? null),
        ];

        $products = Cart::instance('cart')->products();

        if (EcommerceHelper::isEnabledSupportDigitalProducts() && ! EcommerceHelper::canCheckoutForDigitalProducts($products)) {
            return $response
                ->setError()
                ->setNextUrl(route('customer.login'))
                ->setMessage(__('Your shopping cart has digital product(s), so you need to sign in to continue!'));
        }

        if (EcommerceHelper::getMinimumOrderAmount() > Cart::instance('cart')->rawSubTotal()) {
            return $response
                ->setError()
                ->setMessage(__('Minimum order amount is :amount, you need to buy more :more to place an order!', [
                    'amount' => format_price(EcommerceHelper::getMinimumOrderAmount()),
                    'more' => format_price(EcommerceHelper::getMinimumOrderAmount() - Cart::instance('cart')
                            ->rawSubTotal()),
                ]));
        }

        $sessionData = OrderHelper::getOrderSessionData($token);

        $sessionData = $this->processOrderData($token, $sessionData, $request, true);

        foreach ($products as $product) {
            if ($product->isOutOfStock()) {
                return $response
                    ->setError()
                    ->setMessage(__('Product :product is out of stock!', ['product' => $product->original_product->name]));
            }
        }

        $paymentMethod = $request->input('payment_method', session('selected_payment_method'));
        if ($paymentMethod) {
            session()->put('selected_payment_method', $paymentMethod);
        }

        if (is_plugin_active('marketplace')) {
            return apply_filters(
                HANDLE_PROCESS_POST_CHECKOUT_ORDER_DATA_ECOMMERCE,
                $products,
                $request,
                $token,
                $sessionData,
                $response
            );
        }

        $isAvailableShipping = EcommerceHelper::isAvailableShipping($products);

        $shippingMethodInput = $request->input('shipping_method', ShippingMethodEnum::DEFAULT);

        $promotionDiscountAmount = $handleApplyPromotionsService->execute($token);
        $couponDiscountAmount = Arr::get($sessionData, 'coupon_discount_amount');
        $rawTotal = Cart::instance('cart')->rawTotal();
        $orderAmount = max($rawTotal - $promotionDiscountAmount - $couponDiscountAmount, 0);

        $shippingAmount = 0;

        $shippingData = [];
        if ($isAvailableShipping) {
            $origin = EcommerceHelper::getOriginAddress();
            $shippingData = EcommerceHelper::getShippingData($products, $sessionData, $origin, $orderAmount, $paymentMethod);

            $shippingMethodData = $shippingFeeService->execute(
                $shippingData,
                $shippingMethodInput,
                $request->input('shipping_option')
            );

            $shippingMethod = Arr::first($shippingMethodData);
            if (! $shippingMethod) {
                throw ValidationException::withMessages([
                    'shipping_method' => trans('validation.exists', ['attribute' => trans('plugins/ecommerce::shipping.shipping_method')]),
                ]);
            }

            $shippingAmount = Arr::get($shippingMethod, 'price', 0);

            if (get_shipping_setting('free_ship', $shippingMethodInput)) {
                $shippingAmount = 0;
            }
        }

        if (session()->has('applied_coupon_code')) {
            $discount = $applyCouponService->getCouponData(session('applied_coupon_code'), $sessionData);
            if (empty($discount)) {
                $removeCouponService->execute();
            } else {
                $shippingAmount = Arr::get($sessionData, 'is_free_shipping') ? 0 : $shippingAmount;
            }
        }

        $currentUserId = 0;
        if (auth('customer')->check()) {
            $currentUserId = auth('customer')->id();
            $contactData['customer_id'] = $currentUserId;
        }

        $orderAmount += (float)$shippingAmount;

        $request->merge([
            'amount' => $orderAmount ?: 0,
            'currency' => $request->input('currency', strtoupper(get_application_currency()->title)),
            'user_id' => $currentUserId,
            'shipping_method' => $isAvailableShipping ? $shippingMethodInput : '',
            'shipping_option' => $isAvailableShipping ? $request->input('shipping_option') : null,
            'shipping_amount' => (float)$shippingAmount,
            'tax_amount' => Cart::instance('cart')->rawTax(),
            'sub_total' => Cart::instance('cart')->rawSubTotal(),
            'coupon_code' => session()->get('applied_coupon_code'),
            'discount_amount' => $promotionDiscountAmount + $couponDiscountAmount,
            'status' => OrderStatusEnum::PENDING,
            'token' => $token,
        ]);

        $order = $this->orderRepository->getFirstBy(compact('token'));

        $order = $this->createOrderFromData($request->input(), $order);

        $this->orderHistoryRepository->createOrUpdate([
            'action' => 'create_order_from_payment_page',
            'description' => __('Order was created from checkout page'),
            'order_id' => $order->id,
        ]);

        // Fetch the user based on their email or create a new user

        if($contactData['phone']){
            $phone= preg_replace('/[^A-Za-z0-9\-]/', '', $contactData['phone']);
            $string = '+'.str_replace('-', '', $phone);
            $contactData['phone'] = $string;
        }
       // dd($contactData);
        $objContact = Contact::updateOrCreate(
            ['email' => $contactData['email']], // Search condition
            $contactData// Data to update or create
        );
        if ($isAvailableShipping) {
            app(ShipmentInterface::class)->createOrUpdate([
                'order_id' => $order->id,
                'user_id' => 0,
                'weight' => $shippingData ? Arr::get($shippingData, 'weight') : 0,
                'cod_amount' => (is_plugin_active('payment') && $order->payment->id && $order->payment->status != PaymentStatusEnum::COMPLETED) ? $order->amount : 0,
                'cod_status' => ShippingCodStatusEnum::PENDING,
                'type' => $order->shipping_method,
                'status' => ShippingStatusEnum::PENDING,
                'price' => $order->shipping_amount,
                'rate_id' => $shippingData ? Arr::get($shippingMethod, 'id', '') : '',
                'shipment_id' => $shippingData ? Arr::get($shippingMethod, 'shipment_id', '') : '',
                'shipping_company_name' => $shippingData ? Arr::get($shippingMethod, 'company_name', '') : '',
            ]);
        }

        if ($appliedCouponCode = session()->get('applied_coupon_code')) {
            Discount::getFacadeRoot()->afterOrderPlaced($appliedCouponCode);
        }

        $this->orderProductRepository->deleteBy(['order_id' => $order->id]);

        foreach (Cart::instance('cart')->content() as $cartItem) {
            $product = $this->productRepository->findById($cartItem->id);

            $data = [
                'order_id' => $order->id,
                'product_id' => $cartItem->id,
                'product_name' => $cartItem->name,
                'product_image' => $product->original_product->image,
                'qty' => $cartItem->qty,
                'weight' => Arr::get($cartItem->options, 'weight', 0),
                'price' => $cartItem->price,
                'tax_amount' => $cartItem->tax,
                'options' => $cartItem->options,
                'product_type' => $product ? $product->product_type : null,
                'store_id' => $cartItem->options['store_id'],
            ];

            if ($cartItem->options['options']) {
                $data['product_options'] = $cartItem->options['options'];
            }

            $this->orderProductRepository->create($data);

            // save delivery_pickup data
            $deliveryData = [
                'name' => $contactData['first_name'] . ' ' . $contactData['last_name'],
                'phone' => $contactData['mobile_d'],
                'email' => $contactData['delivery_email'],
                'country' => $contactData['delivery_country'],
                'state' => $contactData['delivery_state'],
                'city' => $contactData['delivery_city'],
                'address' => $contactData['delivery_address'],
                'order_id' => $order->id,
                'zip_code' => $contactData['delivery_zipcode'],
                'comment' => '',
                'product_id' => $cartItem->id,
            ];

            $deliveryDate = DateTime::createFromFormat('m/d/Y', $cartItem->options['deldate']);
            $deliveryData['delivery_date'] = $deliveryDate->format('Y-m-d');
            $deliveryData['delivery_status'] = DeliveryStatusEnum::PENDING()->getValue();

            if (isset($cartItem->options['delivery']) && $cartItem->options['delivery']) {
                $deliveryData['customer_delivery'] = SHOP_DELIVERY;
            } else {
                $deliveryData['customer_delivery'] = CUSTOMER_DELIVERY;
            }

            if ($product->rental_type == RENTAL_TYPE_WEEKEND) {
                $deliveryData['delivery_time'] = '14:00:00';
            } else {
                $deliveryData['delivery_time'] = '09:00:00';
            }

            $deliveryDate = DateTime::createFromFormat('m/d/Y', $cartItem->options['deldate']);
            $duration = 1 * $cartItem->qty;
            if ($product->rental_type == RENTAL_TYPE_DAILY) {
                $duration = $duration;
                $pickDate = date('Y-m-d', strtotime( "+$duration day", $deliveryDate->getTimestamp()));
            } else if ($product->rental_type == RENTAL_TYPE_WEEKEND) {
                $duration = $duration * 3;
                $pickDate = date('Y-m-d', strtotime("+$duration days", $deliveryDate->getTimestamp()));
            } else if ($product->rental_type == RENTAL_TYPE_WEEKLY) {
                $duration = $duration * 7;
                $pickDate = date('Y-m-d', strtotime("+$duration days", $deliveryDate->getTimestamp()));
            } else if ($product->rental_type == RENTAL_TYPE_MONTHLY) {
                $duration = $duration * 30;
                $pickDate = date('Y-m-d', strtotime( "+$duration days", $deliveryDate->getTimestamp()));
            } else {
                $pickDate = date('Y-m-d', $deliveryDate->getTimestamp());
            }

            $deliveryData['pickup_date'] = $pickDate;
            $deliveryData['pickup_time'] = '09:00:00';
            $deliveryData['pickup_status'] = DeliveryStatusEnum::PENDING()->getValue();
            if (isset($cartItem->options['pickup']) && $cartItem->options['pickup']) {
                $deliveryData['customer_pickup'] = SHOP_PICKUP;
            } else {
                $deliveryData['customer_pickup'] = CUSTOMER_PICKUP;
            }

            $this->deliveryPickUpRepository->create($deliveryData);

            // save delivery data end
        }

        $request->merge([
            'order_id' => $order->id,
        ]);

        if (! is_plugin_active('payment')) {
            return redirect()->to(route('public.checkout.success', OrderHelper::getOrderSessionToken()));
        }

        $paymentData = [
            'error' => false,
            'message' => false,
            'amount' => (float)format_price($order->amount, null, true),
            'currency' => strtoupper(get_application_currency()->title),
            'type' => $request->input('payment_method'),
            'charge_id' => null,
        ];

        $paymentData = apply_filters(FILTER_ECOMMERCE_PROCESS_PAYMENT, $paymentData, $request);

        if ($checkoutUrl = Arr::get($paymentData, 'checkoutUrl')) {
            return $response
                ->setError($paymentData['error'])
                ->setNextUrl($checkoutUrl)
                ->setData(['checkoutUrl' => $checkoutUrl])
                ->withInput()
                ->setMessage($paymentData['message']);
        }

        if ($paymentData['error'] || ! $paymentData['charge_id']) {
            return $response
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL($token))
                ->withInput()
                ->setMessage($paymentData['message'] ?: __('Checkout error!'));
        }

        return $response
            ->setNextUrl(PaymentHelper::getRedirectURL($token))
            ->setMessage(__('Checkout successfully!'));
    }

    public function getCheckoutSuccess(string $token, BaseHttpResponse $response)
    {
        if (! EcommerceHelper::isCartEnabled()) {
            abort(404);
        }

        $order = $this->orderRepository
            ->getModel()
            ->where('token', $token)
            ->with(['address', 'products'])
            ->orderBy('id', 'desc')
            ->first();

        if (! $order) {
            abort(404);
        }

        if (is_plugin_active('payment') && ! $order->payment_id) {
            return $response
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL())
                ->setMessage(__('Payment failed!'));
        }

        if (is_plugin_active('marketplace')) {
            return apply_filters(PROCESS_GET_CHECKOUT_SUCCESS_IN_ORDER, $token, $response);
        }

        OrderHelper::clearSessions($token);

        $products = collect();

        $productsIds = $order->products->pluck('product_id')->all();

        $useProductTerms = false;
        $useGlobalTerms = false;

        if (! empty($productsIds)) {
            $products = get_products([
                'condition' => [
                    ['ec_products.id', 'IN', $productsIds],
                ],
                'select' => [
                    'ec_products.id',
                    'ec_products.images',
                    'ec_products.name',
                    'ec_products.price',
                    'ec_products.sale_price',
                    'ec_products.sale_type',
                    'ec_products.start_date',
                    'ec_products.end_date',
                    'ec_products.sku',
                    'ec_products.order',
                    'ec_products.created_at',
                    'ec_products.is_variation',
                    'ec_products.use_global',
                    'ec_products.terms_id',
                ],
                'with' => [
                    'variationProductAttributes',
                ],
            ]);

            foreach ($products as $key => $product) {
                if ($product->terms_id) {
                    $term = Terms::where('id', $product->terms_id)->where('status', 'published')->first();
                    if ($term) {
                        $useProductTerms = true;
                    }
                }

                if ($useGlobalTerms == false && $product->use_global == 1) {
                    $useGlobalTerms = true;
                }
            }
        }

        if ($order->terms_signed != 1 && ($useGlobalTerms == true || $useProductTerms == true)) {
            return redirect()->to(route('public.checkout.sign-terms', $token));
        }

        return view('plugins/ecommerce::orders.thank-you', compact('order', 'products'));
    }

    public function getSignTerms(string $token, BaseHttpResponse $response)
    {
        $original_token = $token;
        if ($token === 'static' && false) {
            $order = $this->orderRepository->getModel()->where('status', 'completed')->where('code', '#10000019')->first();
            if (env('APP_ENV') != 'production') {
                $order = $this->orderRepository->getModel()->where('status', 'completed')->orderBy('id', 'DESC')->first();
            }
            if (! $order) {
                abort(404);
            }
            $token = $order->token;
        }
        if (! EcommerceHelper::isCartEnabled()) {
            abort(404);
        }

        $order = $this->orderRepository
            ->getModel()
            ->where('token', $token)
            ->with(['address', 'products'])
            ->orderBy('id', 'desc')
            ->first();

        if (! $order) {
            abort(404);
        }

        if (is_plugin_active('payment') && ! $order->payment_id) {
            return $response
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL())
                ->setMessage(__('Payment failed!'));
        }

        if (is_plugin_active('marketplace')) {
            return apply_filters(PROCESS_GET_CHECKOUT_SUCCESS_IN_ORDER, $token, $response);
        }

        OrderHelper::clearSessions($token);

        $products = collect();

        $productsIds = $order->products->pluck('product_id')->all();
        $useGlobalTerms = false;
        $useProductTerms = false;
        $productTerms = [];
        $combineProductTerm = null;
        if (! empty($productsIds)) {
            $products = get_products([
                'condition' => [
                    ['ec_products.id', 'IN', $productsIds],
                ],
                'select' => [
                    'ec_products.id',
                    'ec_products.images',
                    'ec_products.name',
                    'ec_products.price',
                    'ec_products.sale_price',
                    'ec_products.sale_type',
                    'ec_products.start_date',
                    'ec_products.end_date',
                    'ec_products.sku',
                    'ec_products.order',
                    'ec_products.created_at',
                    'ec_products.is_variation',
                    'ec_products.use_global',
                    'ec_products.terms_id',
                ],
                'with' => [
                    'variationProductAttributes',
                ],
            ]);

            foreach ($products as $key => $product) {
                if ($product->terms_id) {
                    $term = Terms::where('id', $product->terms_id)->where('status', 'published')->first();
                    if ($term) {
                        $htmlContent = str_replace('[customer_initials][/customer_initials]', '<label for="customer_initials"><input name="customer_initials[]" type="checkbox" class="customer_initials_checkbox" required><strong><span style="color: red;">Customer Approval Required</span></strong></label>', $term->content);
                        $productTerms[$product->terms_id] = [
                            'title' => $term->title,
                            'original_content' => $term->content,
                            'html_content' => $htmlContent,
                        ];
                        $combineProductTerm .= "<h4>$term->title</h4>";
                        $combineProductTerm .= $htmlContent;
                        $useProductTerms = true;
                    }
                }

                if ($useGlobalTerms == false && $product->use_global == 1) {
                    $useGlobalTerms = true;
                }
            }
        }

        $globalTerm = Terms::where('is_global', 1)->orderBy('id', 'desc')->first();
        if (! $globalTerm) {
            $useGlobalTerms = false;
        }
        $finalTermHtml = null;
        if ($useGlobalTerms == true) {
            $finalTermHtml = str_replace('[product_terms][/product_terms]', $combineProductTerm, $globalTerm->content);
            $customerName = $order->address->name;
            $finalTermHtml .= str_replace('[customer_name]', $customerName, $globalTerm->signature_block);
            $finalTermHtml = str_replace('[customer_signature]', "<span class='customer_signature_div'><button type='button' class='btn btn-warning open-modal' data-toggle='modal' data-target='#signatureModal'>Sign Here</button></span><button type='button' style='display:none;' class='clear_sign' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>", $finalTermHtml);
        } else {
            $finalTermHtml = $combineProductTerm;
            $customerName = $order->address->name;
            $finalTermHtml .= str_replace('[customer_name]', $customerName, $globalTerm->signature_block);
            $finalTermHtml = str_replace('[customer_signature]', "<span class='customer_signature_div'><button type='button' class='btn btn-warning open-modal' data-toggle='modal' data-target='#signatureModal'>Sign Here</button></span>", $finalTermHtml);
        }
        if ($useProductTerms == false && $useGlobalTerms == false) {
            return redirect()->to(route('public.checkout.success', $token));
        }
        $isadmin = '';
        if(isset($_REQUEST['admin'])){
            $isadmin = $_REQUEST['admin'];
        }


        return view('plugins/ecommerce::orders.sign-terms', compact('order', 'products', 'productTerms', 'useGlobalTerms', 'globalTerm', 'finalTermHtml', 'original_token','isadmin'));
    }

    public function postSignTerms(string $token, BaseHttpResponse $response)
    {
        $request = request();
        $original_token = 'static';

        if ($token === 'static') {
            $order = $this->orderRepository->getModel()->where('status', 'completed')->where('code', '#10000019')->first();
            if (env('APP_ENV') != 'production') {
                $order = $this->orderRepository->getModel()->where('status', 'completed')->orderBy('id', 'DESC')->first();
            }
            if (! $order) {
                abort(404);
            }
            $token = $order->token;
        }

        $order = $this->orderRepository
            ->getModel()
            ->where('token', $token)
            ->with(['address', 'products'])
            ->orderBy('id', 'desc')
            ->first();

        if (! $order) {
            abort(404);
        }
        $products = collect();
        $productsIds = $order->products->pluck('product_id')->all();
        $productTerms = [];
        $combineProductTerm = null;
        if (! empty($productsIds)) {
            $products = get_products([
                'condition' => [
                    ['ec_products.id', 'IN', $productsIds],
                ],
                'select' => [
                    'ec_products.id',
                    'ec_products.images',
                    'ec_products.name',
                    'ec_products.price',
                    'ec_products.sale_price',
                    'ec_products.sale_type',
                    'ec_products.start_date',
                    'ec_products.end_date',
                    'ec_products.sku',
                    'ec_products.order',
                    'ec_products.created_at',
                    'ec_products.is_variation',
                    'ec_products.use_global',
                    'ec_products.terms_id',
                ],
                'with' => [
                    'variationProductAttributes',
                ],
            ]);

            foreach ($products as $key => $product) {
                if ($product->terms_id) {
                    $term = Terms::where('id', $product->terms_id)->where('status', 'published')->first();
                    if ($term) {
                        $htmlContent = str_replace('[customer_initials][/customer_initials]', '<label for="customer_initials"><input name="customer_initials[]" type="checkbox" class="customer_initials_checkbox" required><strong><span style="color: red;">Customer Approval Required</span></strong></label>', $term->content);
                        $productTerms[$product->terms_id] = [
                            'title' => $term->title,
                            'original_content' => $term->content,
                            'html_content' => $htmlContent,
                        ];
                        $combineProductTerm .= "<h4>$term->title</h4>";
                        $combineProductTerm .= $htmlContent;
                    }
                }
            }
        }
        $globalTerm = Terms::where('is_global', 1)->orderBy('id', 'desc')->first();
        $customerName = $order->address->name;
        $finalTermHtml = $globalTerm->content;
        $finalTermHtml .= str_replace('[customer_name]', $customerName, $globalTerm->signature_block);
        $globalTerms = [
            'original_content' => $globalTerm->content,
            'html_content' => $finalTermHtml,
        ];

        $order->terms_signed       = 1;
        $order->signed_terms_html  = $request->signed_terms_html;
        $order->global_terms       = json_encode($globalTerms);
        $order->signature_block    = $globalTerm->signature_block;
        $order->product_terms      = json_encode($productTerms);
        $order->customer_signature = $request->customer_signature;
        $order->save();

        return $response
            ->setNextUrl(PaymentHelper::getRedirectURL($token))
            ->setMessage(__('Terms and Conditions signed successfully!'));
    }

    public function postApplyCoupon(
        ApplyCouponRequest $request,
        HandleApplyCouponService $handleApplyCouponService,
        BaseHttpResponse $response
    ) {
        if (! EcommerceHelper::isCartEnabled()) {
            abort(404);
        }
        $result = [
            'error' => false,
            'message' => '',
        ];
        if (is_plugin_active('marketplace')) {
            $result = apply_filters(HANDLE_POST_APPLY_COUPON_CODE_ECOMMERCE, $result, $request);
        } else {
            $result = $handleApplyCouponService->execute($request->input('coupon_code'));
        }

        if ($result['error']) {
            return $response
                ->setError()
                ->withInput()
                ->setMessage($result['message']);
        }

        $couponCode = $request->input('coupon_code');

        return $response
            ->setMessage(__('Applied coupon ":code" successfully!', ['code' => $couponCode]));
    }

    public function postRemoveCoupon(
        Request $request,
        HandleRemoveCouponService $removeCouponService,
        BaseHttpResponse $response
    ) {
        if (! EcommerceHelper::isCartEnabled()) {
            abort(404);
        }

        if (is_plugin_active('marketplace')) {
            $products = Cart::instance('cart')->products();
            $result = apply_filters(HANDLE_POST_REMOVE_COUPON_CODE_ECOMMERCE, $products, $request);
        } else {
            $result = $removeCouponService->execute();
        }

        if ($result['error']) {
            if ($request->ajax()) {
                return $result;
            }

            return $response
                ->setError()
                ->setData($result)
                ->setMessage($result['message']);
        }

        return $response
            ->setMessage(__('Removed coupon :code successfully!', ['code' => session('applied_coupon_code')]));
    }

    public function getCheckoutRecover(string $token, Request $request, BaseHttpResponse $response)
    {
        if (! EcommerceHelper::isCartEnabled()) {
            abort(404);
        }

        if (! EcommerceHelper::isEnabledGuestCheckout() && ! auth('customer')->check()) {
            return $response->setNextUrl(route('customer.login'));
        }

        if (is_plugin_active('marketplace')) {
            return apply_filters(PROCESS_GET_CHECKOUT_RECOVER_ECOMMERCE, $token, $request);
        }

        $order = $this->orderRepository
            ->getFirstBy([
                'token' => $token,
                'is_finished' => false,
            ], [], ['products', 'address']);

        if (! $order) {
            abort(404);
        }

        if (session()->has('tracked_start_checkout') && session('tracked_start_checkout') == $token) {
            $sessionCheckoutData = OrderHelper::getOrderSessionData($token);
        } else {
            session(['tracked_start_checkout' => $token]);
            $sessionCheckoutData = [
                'name' => $order->address->name,
                'first_name' => $order->address->first_name,
                'last_name' => $order->address->last_name,
                'email' => $order->address->email,
                'phone' => $order->address->phone,
                'address' => $order->address->address,
                'country' => $order->address->country,
                'state' => $order->address->state,
                'city' => $order->address->city,
                'zip_code' => $order->address->zip_code,
                'shipping_method' => $order->shipping_method,
                'shipping_option' => $order->shipping_option,
                'shipping_amount' => $order->shipping_amount,
            ];
        }

        Cart::instance('cart')->destroy();
        foreach ($order->products as $orderProduct) {
            $request->merge(['qty' => $orderProduct->qty]);

            $product = $this->productRepository->findById($orderProduct->product_id);
            if ($product) {
                OrderHelper::handleAddCart($product, $request);
            }
        }

        OrderHelper::setOrderSessionData($token, $sessionCheckoutData);

        return $response->setNextUrl(route('public.checkout.information', $token))
            ->setMessage(__('You have recovered from previous orders!'));
    }

    protected function createOrderFromData(array $data, ?Order $order): Order|null|false
    {
        $data['is_finished'] = false;

        if ($order) {
            $order->fill($data);
            $order = $this->orderRepository->createOrUpdate($order);
        } else {
            $order = $this->orderRepository->createOrUpdate($data);
        }

        if (! $order->referral()->count()) {
            $referrals = app(FootprinterInterface::class)->getFootprints();

            if ($referrals) {
                $order->referral()->create($referrals);
            }
        }

        return $order;
    }
}
