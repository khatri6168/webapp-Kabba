<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderMachineHour extends BaseModel
{
    protected $table = 'ec_order_machine_hours';

    protected $fillable = [
        'start',
        'allocated',
        'end',
        'total',
        'over',
        'over_rate',
        'total_cost',
        'order_id',
        'product_id',
    ];

    public $timestamps = false;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class)->withDefault();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withDefault();
    }
}
