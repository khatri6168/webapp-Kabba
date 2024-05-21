<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Base\Facades\BaseHelper;
use Botble\Support\Http\Requests\Request;
use Botble\Ecommerce\Enums\EmployeeStatusEnum;
use Illuminate\Validation\Rule;

class EmployeeRequest extends Request
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:220',
            'last_name' => 'required|string|max:220',
            'description' => 'nullable|string|max:400',
            'phone' => 'sometimes|' . BaseHelper::getPhoneValidationRule(),
            'email' => 'required|max:60|min:6|email',
            'status' => Rule::in(EmployeeStatusEnum::values()),
        ];
    }
}
