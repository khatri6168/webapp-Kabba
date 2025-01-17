<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Models\BaseModel;
use Botble\Ecommerce\Traits\LocationTrait;
use Botble\Ecommerce\Facades\EcommerceHelper;

class Address extends BaseModel
{
    use LocationTrait;

    protected $table = 'ec_customer_addresses';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'country',
        'state',
        'city',
        'address',
        'zip_code',
        'customer_id',
        'is_default',
    ];

    protected $appends = ['first_name','last_name'];

    public function getFirstNameAttribute()
    {
        $nameParts = [];
        if (isset($this->attributes['name'])) {
            $nameParts = explode(' ', $this->attributes['name']);
        }
        return $nameParts[0] ?? null;
    }

    public function getLastNameAttribute()
    {
        $nameParts = [];
        if (isset($this->attributes['name'])) {
            $nameParts = explode(' ', $this->attributes['name']);
        }
        return count($nameParts) > 1 ? end($nameParts) : null;
    }
    
    public function getFullAddressAttribute(): string
    {
        return ($this->address ? ($this->address . ', ') : null) .
            ($this->city_name ? ($this->city_name . ', ') : null) .
            ($this->state_name ? ($this->state_name . ', ') : null) .
            (EcommerceHelper::isUsingInMultipleCountries() ? ($this->country_name ?: null) : '') .
            (EcommerceHelper::isZipCodeEnabled() && $this->zip_code ? ', ' . $this->zip_code : '');
    }
}
