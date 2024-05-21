<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Models\BaseModel;
use Botble\Ecommerce\Enums\EmployeeStatusEnum;

class Employee extends BaseModel
{
    protected $table = 'ec_employees';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'status',
    ];

    protected $casts = [
        'status' => EmployeeStatusEnum::class,
        'first_name' => SafeContent::class,
        'last_name' => SafeContent::class,
        'address' => SafeContent::class,
        'email' => SafeContent::class,
        'phone' => SafeContent::class,
    ];

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
