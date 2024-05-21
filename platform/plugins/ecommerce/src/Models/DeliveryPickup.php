<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Models\BaseModel;
use Botble\Ecommerce\Enums\DeliveryTypeEnum;
use Botble\Ecommerce\Enums\DeliveryStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryPickup extends BaseModel
{
    protected $table = 'ec_delivery_pickup';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'country',
        'state',
        'city',
        'address',
        'order_id',
        'product_id',
        'zip_code',
        'type',
        'comment',
        'delivery_date',
        'delivery_time',
        'delivery_status',
        'pickup_date',
        'pickup_time',
        'pickup_status',
        'customer_pickup',
        'customer_delivery',
    ];

    public $timestamps = true;

    protected $casts = [
        'delivery_status' => DeliveryStatusEnum::class,
        'pickup_status' => DeliveryStatusEnum::class,
        'address' => SafeContent::class,
        'email' => SafeContent::class,
        'phone' => SafeContent::class,
    ];

    protected $appends = ['location'];

    public function getLocationAttribute()
    {
        return $this->attributes['address'].', '.$this->attributes['city']. ', ' .$this->attributes['state']. ', ' .$this->attributes['country']. ', ' .$this->attributes['zip_code'];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class)->withDefault();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withDefault();
    }
}
