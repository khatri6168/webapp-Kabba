<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Models\BaseModel;

class DeliveryNote extends BaseModel
{
    protected $table = 'ec_delivery_notes';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'notes'
    ];
}
