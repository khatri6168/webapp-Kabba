<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Models\BaseModel;
use Botble\Ecommerce\Traits\LocationTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoreLocator extends BaseModel
{
    use LocationTrait;

    protected $table = 'ec_store_locators';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'country',
        'state',
        'city',
        'zip_code',
        'is_primary',
        'is_shipping_location',
        'color',
    ];

    public function orderProduct(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'store_id')->with(['store']);
    }
}
