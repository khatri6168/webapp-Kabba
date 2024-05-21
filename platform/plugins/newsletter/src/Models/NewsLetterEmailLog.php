<?php

namespace Botble\Newsletter\Models;

use Botble\Base\Models\BaseModel;

class NewsLetterEmailLog extends BaseModel
{
    protected $table = 'newsletter_email_logs';

    protected $fillable = [
        'receiver_email',
        'template_id',
        'subject',
        'content',
        'status',
        'created_at',
        'updated_at',
        'number_of_users'
    ];
}
