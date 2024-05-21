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
use Botble\Contact\Models\ContactNote;
use Botble\Payment\Models\Payment;

class Contact extends BaseModel
{
    protected $table = 'contacts';

    protected $fillable = [
        //'name',
        'customer_id',
        'first_name',
        'last_name',
        'name',
        'company',
        'tax_id',
        'email',
        'phone',
        'phone2',
        'phone_2',
        'address',
        'url',
        'companyaddress',
        'companycity',
        'companystate',
        'companycountry',
        'companyzipcode',
        'zipcode',
        'city',
        'state',
        'country',
        'delivery_first_name',
        'delivery_last_name',
        'delivery_email',
        'delivery_mobile',
        'delivery_mobile2',
        'delivery_address',
        'delivery_zipcode',
        'delivery_city',
        'delivery_state',
        'delivery_country',
        'subject',
        'content',
        'note',
        'contactTag',
        'status',
        'skype',
        'same_as_company',
        'same_as_delivery'
        //'currency',
    ];

    protected $casts = [
        'status' => ContactStatusEnum::class,
        'name' => SafeContent::class,
        'address' => SafeContent::class,
        'delivery_name' => SafeContent::class,
       // 'delivery_address' => SafeContent::class,
        'subject' => SafeContent::class,
        'content' => SafeContent::class,
    ];

    public function replies(): HasMany
    {
        return $this->hasMany(ContactReply::class);
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                try {
                    return (new Avatar())->create($this->name)->toBase64();
                } catch (Exception) {
                    return RvMedia::getDefaultImage();
                }
            },
        );
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'customer_id', 40);
    }
}
