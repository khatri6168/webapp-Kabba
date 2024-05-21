<?php

namespace Botble\Contact\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Supports\Avatar;
use Botble\Contact\Enums\ContactStatusEnum;
use Botble\Base\Models\BaseModel;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Botble\Media\Facades\RvMedia;

class Company extends BaseModel
{
    protected $table = 'companies';

    protected $fillable = [
        'id',
        'company_name',
        'company_email',
        'company_url',
        'company_country',
        'company_address',
    ];
}
