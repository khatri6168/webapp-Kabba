<?php

namespace Botble\Authorizenet\Http\Controllers;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Supports\PaymentHelper;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class AuthorizenetController extends Controller
{
    public function success(Request $request, BaseHttpResponse $response)
    {
        $session_id = $request->input('session_id') ? base64_decode($request->input('session_id')) : null;
        
        try {
            if ($session_id) {
                $sessionData = session("authorizenetPaymnetData_".$session_id);
                // dd($sessionData);
                $chargeId = $sessionData['charge_id'];
                // dd(PaymentHelper::getRedirectURL());
                return $response
                    ->setNextUrl(PaymentHelper::getRedirectURL() . '?charge_id=' . $chargeId)
                    ->setMessage(__('Checkout successfully!'));
            }

            return $response
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL())
                ->setMessage(__('Payment failed!'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL())
                ->withInput()
                ->setMessage($exception->getMessage() ?: __('Payment failed!'));
        }
    }

    public function error(Request $request, BaseHttpResponse $response)
    {
        $session_id = $request->input('session_id') ? base64_decode($request->input('session_id')) : null;
        $sessionData = session("authorizenetPaymnetData_".$session_id);
        $message = $sessionData['message'] ?? 'Payment failed!';
        // dd(PaymentHelper::getCancelURL(), $message);
        return $response
            ->setError()
            ->setNextUrl(PaymentHelper::getCancelURL())
            ->withInput()
            ->setMessage(__($message));
    }
}
