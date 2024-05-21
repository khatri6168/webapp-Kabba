<?php

namespace Botble\Contact\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Models\BaseModel;

class ContactNote extends BaseModel
{
    protected $table = 'contact_notes';

    protected $fillable = [
        'id',
        'company_id',
        'notes'
    ];
}
