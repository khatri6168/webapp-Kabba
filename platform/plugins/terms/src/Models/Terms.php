<?php

namespace Botble\Terms\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Terms extends BaseModel
{
    protected $table = 'terms';

    protected $fillable = [
        'title',
        'content',
        'is_global',
        'slug',
        'signature_block',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'content' => SafeContent::class,
    ];
}
