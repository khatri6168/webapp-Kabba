<?php

namespace Botble\Ecommerce\Enums;

use Botble\Base\Supports\Enum;
use Botble\Base\Facades\Html;
use Illuminate\Support\HtmlString;

/**
 * @method static StockStatusEnum DELETED()
 * @method static StockStatusEnum AVAILABLE()
 */
class EmployeeStatusEnum extends Enum
{
    public const DELETED = 'deleted';
    public const AVAILABLE = 'available';

    public static $langPath = 'plugins/ecommerce::employees.statuses';

    public function toHtml(): HtmlString|string
    {
        return match ($this->value) {
            self::DELETED => Html::tag('span', self::DELETED()->label(), ['class' => 'label-danger status-label'])
                ->toHtml(),
            self::AVAILABLE => Html::tag('span', self::AVAILABLE()->label(), ['class' => 'label-success status-label'])
                ->toHtml(),
            default => parent::toHtml(),
        };
    }
}
