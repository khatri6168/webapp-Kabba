<?php

namespace Botble\Ecommerce\Enums;

use Botble\Base\Supports\Enum;
use Botble\Ecommerce\Option\OptionType\Checkbox;
use Botble\Ecommerce\Option\OptionType\Dropdown;
use Botble\Ecommerce\Option\OptionType\Field;
use Botble\Ecommerce\Option\OptionType\RadioButton;
use Botble\Ecommerce\Option\OptionType\Rental;

class GlobalOptionEnum extends Enum
{
    public const NA = 'N/A';

    public const FIELD = Field::class;

    public const TYPE_PERCENT = 1;

    public static function options(): array
    {
        return [
            'N/A' => trans('plugins/ecommerce::product-option.please_select_option'),
            'Text' => [
                Field::class => 'Field',
            ],
            'Select' => [
                Dropdown::class => 'Dropdown',
                Checkbox::class => 'Checkbox',
                RadioButton::class => 'RadioButton',
            ],
        ];
    }
    public static function newOptions(): array
    {
        return [
            /* 'N/A' => trans('plugins/ecommerce::product-option.please_select_option'),
            Dropdown::class => 'Dropdown',
            Checkbox::class => 'Checkbox',
            RadioButton::class => 'RadioButton',
            Rental::class => 'Rental', */
            'N/A' => trans('plugins/ecommerce::product-option.please_select_option'),
            'Text' => [
                Field::class => 'Field',
            ],
            'Select' => [
                Dropdown::class => 'Dropdown',
                Checkbox::class => 'Checkbox',
                RadioButton::class => 'RadioButton',
                Rental::class => 'Rental',
            ],
        ];
    }
}
