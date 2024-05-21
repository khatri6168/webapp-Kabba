<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Ecommerce\Enums\ShippingMethodEnum;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Support\Http\Requests\Request;
use Botble\Ecommerce\Facades\Cart;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CheckoutRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'amount' => 'required|min:0',
        ];

        if (is_plugin_active('payment')) {
            $paymentMethods = Arr::where(PaymentMethodEnum::values(), function ($value) {
                return get_payment_setting('status', $value) == 1;
            });

            $rules['payment_method'] = 'required|' . Rule::in($paymentMethods);
        }

        $addressId = $this->input('address.address_id');

        $products = Cart::instance('cart')->products();
        if (EcommerceHelper::isAvailableShipping($products)) {
            $rules['shipping_method'] = 'required|' . Rule::in(ShippingMethodEnum::values());
            if (auth('customer')->check()) {
                $rules['address.address_id'] = 'required_without:address.first_name';
                if (! $this->has('address.address_id') || $addressId === 'new') {
                    $rules = array_merge($rules, EcommerceHelper::getCustomerAddressValidationRules('address.'));
                }
            } else {
                $rules = array_merge($rules, EcommerceHelper::getCustomerAddressValidationRules('address.'));
            }

        }

        $billingAddressSameAsShippingAddress = false;
        if (EcommerceHelper::isBillingAddressEnabled()) {
            $isSaveOrderShippingAddress = EcommerceHelper::isSaveOrderShippingAddress($products);
            $rules['billing_address_same_as_shipping_address'] = 'nullable|' . Rule::in(['0', '1']);

            if (! $this->input('billing_address_same_as_shipping_address') || (! $isSaveOrderShippingAddress && auth('customer')->check() && ! $addressId)) {
                $rules['billing_address'] = 'array';
                $rules = array_merge($rules, EcommerceHelper::getCustomerAddressValidationRules('billing_address.'));
            } else {
                $billingAddressSameAsShippingAddress = true;
            }
        }

        if (! auth('customer')->check()) {
            $rules = array_merge($rules, EcommerceHelper::getCustomerAddressValidationRules('address.'));
//            $rules['address.email'] = 'required|email|unique:ec_customers,email|max:60|min:6';
            $rules['address.email'] = [
                'required','max:60', 'min:6','email', Rule::unique('ec_customers', 'email')->where(function ($query) {
                    return $query->where('type', 'Customer');
                })
            ];
            if (EcommerceHelper::countDigitalProducts($products) == $products->count() && ! $billingAddressSameAsShippingAddress) {
                $rules = $this->removeRequired($rules, [
                    'address.country',
                    'address.state',
                    'address.city',
                    'address.address',
                    'address.phone',
                    'address.zip_code',
                ]);
            }
        }

        $isCreateAccount = ! auth('customer')->check() && $this->input('create_account') == 1;
        if ($isCreateAccount) {
            $rules['password'] = 'required|min:6';
            $rules['password_confirmation'] = 'required|same:password';
//            $rules['address.email'] = 'required|max:60|min:6|email|unique:ec_customers,email';
            $rules['address.email'] = [
                'required','max:60', 'min:6','email', Rule::unique('ec_customers', 'email')->where(function ($query) {
                    return $query->where('type', 'Customer');
                })
            ];
            $rules['address.first_name'] = 'required|min:3|max:120';
            $rules['address.last_name'] = 'required|min:3|max:120';
        }

        // if the request is "POST" and "register account" is unchecked
        if ($this->input('create_account') != 1 && $this->method() == 'POST') {
            unset($rules['password_confirmation']);
            unset($rules['password']);
        } else {
            $rules['password_confirmation'] = 'required|same:password';
            $rules['password'] = 'required|min:6';
        }

        $availableMandatoryFields = EcommerceHelper::getEnabledMandatoryFieldsAtCheckout();
        $mandatoryFields = array_keys(EcommerceHelper::getMandatoryFieldsAtCheckout());
        $nullableFields = array_diff($mandatoryFields, $availableMandatoryFields);
        $hiddenFields = EcommerceHelper::getHiddenFieldsAtCheckout();

        if ($hiddenFields) {
            Arr::forget($rules, array_map(fn ($value) => "address.$value", $hiddenFields));
        }

        if ($nullableFields) {
            foreach ($nullableFields as $value) {
                $key = "address.$value";

                if (isset($rules[$key])) {
                    $rules[$key] = str_replace('required', 'nullable', $rules[$key]);
                }
            }
        }

        return apply_filters(PROCESS_CHECKOUT_RULES_REQUEST_ECOMMERCE, $rules);
    }

    public function messages(): array
    {
        return apply_filters(PROCESS_CHECKOUT_MESSAGES_REQUEST_ECOMMERCE, [
            'address.first_name.required' => trans('plugins/ecommerce::order.address_first_name_required'),
            'address.last_name.required' => trans('plugins/ecommerce::order.address_last_name_required'),
            'address.phone.required' => trans('plugins/ecommerce::order.address_phone_required'),
            'address.email.required' => trans('plugins/ecommerce::order.address_email_required'),
            'address.email.unique' => 'There is an account already created with this email address. Please login to add this order to your account history or use a different email address and checkout as a Guest.',
            'address.state.required' => trans('plugins/ecommerce::order.address_state_required'),
            'address.city.required' => trans('plugins/ecommerce::order.address_city_required'),
            'address.country.required' => trans('plugins/ecommerce::order.address_country_required'),
            'address.address.required' => trans('plugins/ecommerce::order.address_address_required'),
            'address.zip_code.required' => trans('plugins/ecommerce::order.address_zipcode_required'),

            'billing_address.first_name.required' => trans('plugins/ecommerce::order.address_first_name_required'),
            'billing_address.last_name.required' => trans('plugins/ecommerce::order.address_last_name_required'),
            'billing_address.phone.required' => trans('plugins/ecommerce::order.address_phone_required'),
            'billing_address.email.required' => trans('plugins/ecommerce::order.address_email_required'),
            'billing_address.email.unique' => trans('plugins/ecommerce::order.address_email_unique'),
            'billing_address.state.required' => trans('plugins/ecommerce::order.address_state_required'),
            'billing_address.city.required' => trans('plugins/ecommerce::order.address_city_required'),
            'billing_address.country.required' => trans('plugins/ecommerce::order.address_country_required'),
            'billing_address.address.required' => trans('plugins/ecommerce::order.address_address_required'),
            'billing_address.zip_code.required' => trans('plugins/ecommerce::order.address_zipcode_required'),
        ]);
    }

    public function attributes(): array
    {
        return [
            'address.first_name' => __('First Name'),
            'address.last_name' => __('Last Name'),
            'address.phone' => __('Phone'),
            'address.email' => __('Email'),
            'address.state' => __('State'),
            'address.city' => __('City'),
            'address.country' => __('Country'),
            'address.address' => __('Address'),
            'address.zip_code' => __('Zipcode'),
        ];
    }

    public function removeRequired(array $rules, string|array $keys): array
    {
        if (! is_array($keys)) {
            $keys = [$keys];
        }
        foreach ($keys as $key) {
            if (! empty($rules[$key])) {
                $values = $rules[$key];
                if (is_string($values)) {
                    $explode = explode('|', $values);
                    if (($k = array_search('required', $explode)) !== false) {
                        unset($explode[$k]);
                    }
                    $explode[] = 'nullable';
                    $values = $explode;
                } elseif (is_array($values)) {
                    if (($k = array_search('required', $values)) !== false) {
                        unset($values[$k]);
                    }
                    $values[] = 'nullable';
                }
                $rules[$key] = $values;
            }
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        // Combine first_name and last_name into name if they exist
        $requestData = $this->all();

        if (isset($requestData['billing_address']['first_name']) && isset($requestData['billing_address']['last_name'])) {
            $requestData['billing_address']['name'] = $requestData['billing_address']['first_name'] . ' ' . $requestData['billing_address']['last_name'];
        }

        if (isset($requestData['address']['first_name']) && isset($requestData['address']['last_name'])) {
            $requestData['address']['name'] = $requestData['address']['first_name'] . ' ' . $requestData['address']['last_name'];
        }

        $this->replace($requestData);

        // Share the request data
        $this->request->add(['requestData' => $requestData]);
    }

}
