<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Base\Facades\BaseHelper;
use Botble\Support\Http\Requests\Request;
use Botble\Ecommerce\Enums\DeliveryStatusEnum;
use Illuminate\Validation\Rule;

class DeliveryPickUpRequest extends Request
{
    public function rules(): array
    {
        return [
            'delivery_date' => 'required|string',
            'delivery_time' => 'required|string',
            'pickup_date' => 'required|string',
            'pickup_time' => 'required|string',
            'delivery_status' => Rule::in(DeliveryStatusEnum::values()),
            'pickup_status' => Rule::in(DeliveryStatusEnum::values()),
        ];
    }
}
