<?php

namespace Botble\Authorizenet\Providers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Botble\Base\Facades\Html;
use Botble\Ecommerce\Models\Address;
use Botble\Ecommerce\Models\Customer;
use Botble\Ecommerce\Models\Order;
use Illuminate\Support\ServiceProvider;
use Botble\Payment\Facades\PaymentMethods;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Enums\PaymentStatusEnum;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Botble\Stripe\Services\Gateways\StripePaymentService;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, [$this, 'registerAuthorizenetMethod'], 1, 2);

        $this->app->booted(function () {
            add_filter(PAYMENT_FILTER_AFTER_POST_CHECKOUT, [$this, 'checkoutWithAuthorizenet'], 1, 2);
        });

        add_filter(PAYMENT_METHODS_SETTINGS_PAGE, [$this, 'addPaymentSettings'], 1);

        add_filter(BASE_FILTER_ENUM_ARRAY, function ($values, $class) {
            if ($class == PaymentMethodEnum::class) {
                $values['AUTHORIZENET'] = AUTHORIZENET_PAYMENT_METHOD_NAME;
            }

            return $values;
        }, 1, 2);

        add_filter(BASE_FILTER_ENUM_LABEL, function ($value, $class) {
            if ($class == PaymentMethodEnum::class && $value == AUTHORIZENET_PAYMENT_METHOD_NAME) {
                $value = 'Authorizenet';
            }

            return $value;
        }, 1, 2);

        add_filter(BASE_FILTER_ENUM_HTML, function ($value, $class) {
            if ($class == PaymentMethodEnum::class && $value == AUTHORIZENET_PAYMENT_METHOD_NAME) {
                $value = Html::tag(
                    'span',
                    PaymentMethodEnum::getLabel($value),
                    ['class' => 'label-success status-label']
                )
                    ->toHtml();
            }

            return $value;
        }, 1, 2);

        add_filter(PAYMENT_FILTER_GET_SERVICE_CLASS, function ($data, $value) {
            if ($value == AUTHORIZENET_PAYMENT_METHOD_NAME) {
                $data = StripePaymentService::class;
            }

            return $data;
        }, 1, 2);

        add_filter(PAYMENT_FILTER_PAYMENT_INFO_DETAIL, function ($data, $payment) {
            if ($payment->payment_channel == AUTHORIZENET_PAYMENT_METHOD_NAME) {
                $paymentDetail = (new StripePaymentService())->getPaymentDetails($payment->charge_id);

                $data = view('plugins/authorizenet::detail', ['payment' => $paymentDetail])->render();
            }

            return $data;
        }, 1, 2);

        if (defined('PAYMENT_FILTER_FOOTER_ASSETS')) {
            add_filter(PAYMENT_FILTER_FOOTER_ASSETS, function ($data) {
                if ($this->app->make(StripePaymentService::class)->isStripeApiCharge()) {
                    return $data . view('plugins/authorizenet::assets')->render();
                }

                return $data;
            }, 1);
        }
    }

    public function addPaymentSettings(?string $settings): string
    {
        return $settings . view('plugins/authorizenet::settings')->render();
    }

    public function registerAuthorizenetMethod(?string $html, array $data): string
    {
        PaymentMethods::method(AUTHORIZENET_PAYMENT_METHOD_NAME, [
            'html' => view('plugins/authorizenet::methods', $data)->render(),
        ]);

        return $html;
    }

    public function checkoutWithAuthorizenet(array $data, Request $request): array
    {
        if ($data['type'] !== AUTHORIZENET_PAYMENT_METHOD_NAME) {
            return $data;
        }

         

        // dd($allrequest);
        $request->validate([
            'card_number' => 'required', // Card number is required
            'mm_yy' => [
                'required', // MM/YY is required
                //'regex:/^\d{2}\s*\/\s*\d{4}$/',
                //'date_format:m / Y',
            ],
        ], [
            'mm_yy.required' => 'Card Expiry is required',
            //'mm_yy.regex' => 'The MM/YYYY field must be in the format MM/YYYY (e.g., 05/2023).',
            //'mm_yy.date_format' => 'The MM/YYYY field must be in the format MM/YYYY (e.g., 05/2023).',
        ]);

        $input = $request->all();
        //dd($input['user_id']);
        $address_id = $request->address['address_id'] ?? null;
        if ($address_id && $address_id != 'new') {
            $address = Address::find($address_id);
            $address = $address ? $address->toArray() : [];
        } else {
            $address = $request->address;
        }
        
        
        $customer = Customer::find($input['user_id']);
        $orderDetails = Order::find($request->order_id);
         //dd($customer, $input);
        
        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($address['name'] ?? null);
        // $customerAddress->setLastName("Johnson");
        // $customerAddress->setCompany("Souveniropolis");
        $customerAddress->setAddress($address['address'] ?? null);
        $customerAddress->setCity($address['city'] ?? null);
        $customerAddress->setState($address['state'] ?? null);
        $customerAddress->setZip($address['zip_code'] ?? null);
        $customerAddress->setCountry($address['country'] ?? null);
        $customerAddress->setEmail($address['email'] ?? null);

        // Set the customer's identifying information
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType("individual");
        $customerData->setId($customer->id ?? null);
        $customerData->setEmail($customer->email ?? $address['email'] ?? null);

        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($orderDetails->code ?? null);
        // $order->setDescription("Golf Shirts");

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(setting('payment_authorizenet_merchant_login_id'));
        $merchantAuthentication->setTransactionKey(setting('payment_authorizenet_merchant_transaction_key'));

        $refId = 'rentalapp' . time();
        $cardNumber = preg_replace('/\s+/', '', $input['card_number']);
        $expiry = $input['mm_yy'];

         $expdate = explode('/ ',$expiry);
         $expdate[1] = '20'.$expdate[1];
         $expiry = implode(' / ',$expdate);

        $expiry = preg_replace('/\s+/', '', $expiry);
        $expiryData = explode('/', $expiry);
        $expiration_month = $expiryData[0];
        $expiration_year = $expiryData[1];

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($expiration_year . "-" . $expiration_month);
        $creditCard->setCardCode($input['cvc']);
        
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
        $customerProfile->setDescription("Customer Order Profile");
        // $customerProfile->setMerchantCustomerId("M_" . time());
        $customerProfile->setMerchantCustomerId("RA_" . time());
        $customerProfile->setEmail($customer->email ?? $address['email'] ?? null);
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

        if (($cpResponse != null) && ($cpResponse->getMessages()->getResultCode() == "Ok")) {
            // echo "Succesfully created customer profile : " . $cpResponse->getCustomerProfileId() . "\n";
            $customerProfileId = $cpResponse->getCustomerProfileId();
            $paymentProfiles = $cpResponse->getCustomerPaymentProfileIdList();
            $paymentProfileId = $paymentProfiles[0];
            $orderDetails->authorize_customer_id = $customerProfileId;
            $orderDetails->authorize_customer_payment_id = $paymentProfileId;
            $orderDetails->save();
            // dd($orderDetails);
        } else {
            // echo "ERROR :  Invalid response\n";
            $errorMessages = $cpResponse->getMessages()->getMessage();
            $errorMessage = $errorMessages[0]->getText();
            // echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
            // return redirect()->back()->withErrors(['error' => $errorMessages]);
            $orderId = $input['order_id'];
            $data['error'] = true;
            $data['message'] = $errorMessage;
            if ($data['error'] == true) {
                $data['checkoutUrl'] = route('payments.authorizenet.error')."?session_id=".base64_encode($input['order_id']);
                $paymentStatus = PaymentStatusEnum::FAILED;
            }
            $authorizenetPaymnetData = [
                'amount'          => $input['amount'],
                'currency'        => $input['currency'],
                'charge_id'       => null,
                'order_id'        => $input['order_id'],
                'customer_id'     => Arr::get($input, 'user_id'),
                'customer_type'   => 'Botble\Ecommerce\Models\Customer',
                'payment_channel' => AUTHORIZENET_PAYMENT_METHOD_NAME,
                'status'          => $paymentStatus,
                'message'         => $data['message'] ?? null,
            ];
            session(["authorizenetPaymnetData_$orderId" => $authorizenetPaymnetData]);
    
            do_action(PAYMENT_ACTION_PAYMENT_PROCESSED, $authorizenetPaymnetData);
    
            return $data;
        }
        // dd($cpResponse);

        $profileToCharge = new AnetAPI\CustomerProfilePaymentType();
        $profileToCharge->setCustomerProfileId($customerProfileId);
        $paymentProfile = new AnetAPI\PaymentProfileType();
        $paymentProfile->setPaymentProfileId($paymentProfileId);
        $profileToCharge->setPaymentProfile($paymentProfile);

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($input['amount']);
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
        // dd($response);
        
        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
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
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                    $msg_type = "success_msg";
                    
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
                    $msg_type = "error_msg";
                    $data['error'] = true;
                    $data['message'] = $message_text;

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error_msg";
                        $data['error'] = true;
                        $data['message'] = $message_text;
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $message_text = 'There were some issue with the payment. Please try again later.';
                $msg_type = "error_msg";
                $data['error'] = true;
                $data['message'] = $message_text;

                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                    $msg_type = "error_msg";
                    $data['error'] = true;
                    $data['message'] = $message_text;
                } else {
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                    $msg_type = "error_msg";
                    $data['error'] = true;
                    $data['message'] = $message_text;
                }                
            }

            $chargeId = $tresponse->getTransId() == 0 ? $refId : $tresponse->getTransId();
        } else {
            $chargeId = $refId;
            $message_text = "No response returned";
            $msg_type = "error_msg";
            $data['error'] = true;
            $data['message'] = $message_text;
        }
        $chargeId = $chargeId ?? $refId;
        $orderId = $input['order_id'];
        $paymentStatus = PaymentStatusEnum::COMPLETED;
        $data['checkoutUrl'] = route('payments.authorizenet.success')."?session_id=".base64_encode($orderId);
        if ($data['error'] == true) {
            $data['checkoutUrl'] = route('payments.authorizenet.error')."?session_id=".base64_encode($orderId);
            $paymentStatus = PaymentStatusEnum::FAILED;
        }
        $authorizenetPaymnetData = [
            'amount'          => $input['amount'],
            'currency'        => $input['currency'],
            'charge_id'       => $chargeId,
            'order_id'        => $input['order_id'],
            'customer_id'     => Arr::get($input, 'user_id'),
            'customer_type'   => 'Botble\Ecommerce\Models\Customer',
            'payment_channel' => AUTHORIZENET_PAYMENT_METHOD_NAME,
            'status'          => $paymentStatus,
            'message'         => $data['message'] ?? null,
        ];
        session(["authorizenetPaymnetData_$orderId" => $authorizenetPaymnetData]);

        do_action(PAYMENT_ACTION_PAYMENT_PROCESSED, $authorizenetPaymnetData);

        return $data;
    }
}
