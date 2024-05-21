<?php

namespace Botble\Ecommerce\Enums;

use Botble\Base\Supports\Enum;
use Botble\Base\Facades\Html;
use Illuminate\Support\HtmlString;

/**
 * @method static DeliveryTypeEnum DELIVERY()
 * @method static DeliveryTypeEnum PICKUP()
 */
class DeliveryTypeEnum extends Enum
{
    public const DELIVERY = '1';
    public const PICKUP = '2';
    public const CUSTOMER_DELIVERY = '3';
    public const CUSTOMER_PICKUP = '4';

    public static $langPath = 'plugins/ecommerce::deliveries.types';

    public function toHtml(): HtmlString|string
    {
        return match ($this->value) {
            self::DELIVERY => Html::tag('span', self::DELIVERY()->label(), ['class' => 'label-danger status-label'])
                ->toHtml(),
            self::PICKUP => Html::tag('span', self::PICKUP()->label(), ['class' => 'label-success status-label'])
                ->toHtml(),
            default => parent::toHtml(),
        };
    }
}
