<?php

namespace Botble\Contact\Models;


use Botble\Base\Models\BaseModel;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Botble\Media\Facades\RvMedia;

class Contacttag extends BaseModel
{
    protected $table = 'contacttags';

    protected $fillable = [
        'name',
        
    ];


}
