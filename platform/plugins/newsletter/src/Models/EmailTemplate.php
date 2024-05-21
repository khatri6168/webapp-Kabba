<?php

namespace Botble\Newsletter\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Models\BaseModel;
use Botble\Newsletter\Enums\NewsletterStatusEnum;

class EmailTemplate extends BaseModel
{
    protected $table = 'email_templates';

    protected $fillable = [
        'name',
        'subject',
        'slug',
        'description',
    ];
}
