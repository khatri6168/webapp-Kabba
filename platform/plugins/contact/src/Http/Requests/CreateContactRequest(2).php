<?php

namespace Botble\Contact\Http\Requests;

use Botble\Contact\Enums\ContactStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CreateContactRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            // 'subject' => 'required',
            // 'content' => 'required',
            'status' => 'required',
            'company' => 'required',
            'tax_id' => 'required',
            'phone_2' => 'required',
            'zipcode' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'delivery_name' => 'required',
            'delivery_address' => 'required',
            'delivery_zipcode' => 'required',
            'delivery_city' => 'required',
            'delivery_state' => 'required',
            'delivery_country' => 'required',
            'currency' => 'required',
            'status' => Rule::in(ContactStatusEnum::values()),
        ];
    }
}
