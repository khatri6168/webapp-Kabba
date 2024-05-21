<?php

namespace Botble\Ecommerce\Enums;

use Botble\Base\Supports\Enum;
use Botble\Base\Facades\Html;
use Illuminate\Support\HtmlString;

/**
 * @method static DeliveryStatusEnum PENDING()
 * @method static DeliveryStatusEnum COMPLETED()
 */
class DeliveryStatusEnum extends Enum
{
    public const PENDING = '1';
    public const COMPLETED = '2';

    public static $langPath = 'plugins/ecommerce::deliveries.statuses';

    public function toHtml(): HtmlString | string
    {
        return match ($this->value) {
            self::PENDING => Html::tag('span', self::PENDING()->label(), ['class' => 'label-info status-label'])
                ->toHtml(),
            self::COMPLETED => Html::tag('span', self::COMPLETED()->label(), ['class' => 'label-success status-label'])
                ->toHtml(),
            default => parent::toHtml(),
        };
    }
}
