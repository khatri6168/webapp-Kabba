<?php

namespace Botble\Terms\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class TermsRequest extends Request
{
    public function rules(): array
    {
        return [
            'content'   => 'required|string',
            'title'     => 'required|string',
            'status'    => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
