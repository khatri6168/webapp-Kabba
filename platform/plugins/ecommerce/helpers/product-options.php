<?php

use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Models\Product;

if (! function_exists('render_product_options')) {
    function render_product_options(Product $product): string
    {
        if (! EcommerceHelper::isEnabledProductOptions()) {
            return '';
        }

        $product->loadMissing(['options', 'options.values']);

        if (! $product->options) {
            return '';
        }

        $html = '<div class="pr_switch_wrap" id="product-option">';

        $script = 'vendor/core/plugins/ecommerce/js/change-product-options.js';

        Theme::asset()->container('footer')->add('change-product-options', $script, ['jquery']);
        Theme::asset()->container('footer')->add('sweetalert2-css', 'https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css');
        Theme::asset()->container('footer')->add('sweetalert2-js', 'https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js', ['jquery']);

        foreach ($product->options as $option) {
            $typeClass = __NAMESPACE__ . '\\' . $option->option_type;
            if (class_exists($typeClass)) {
                $instance = new $typeClass();
                $html .= $instance->setOption($option)->setProduct($product)->render();
            } else {
                Log::error(sprintf('Class %s not found', $typeClass));
            }
        }

        $html .= '</div>';

        if (! request()->ajax()) {
            return $html;
        }

        return $html . Html::script($script)->toHtml();
    }
}

if (! function_exists('render_product_options_info')) {
    function render_product_options_info(array $productOptions, ?Product $product, bool $displayBasePrice = false): string
    {
        if (! EcommerceHelper::isEnabledProductOptions()) {
            return '';
        }

        $view = Theme::getThemeNamespace('views.ecommerce.options.render-options-info');

        if (! view()->exists($view)) {
            $view = 'plugins/ecommerce::themes.options.render-options-info';
        }

        return view($view, compact('productOptions', 'product', 'displayBasePrice'))->render();
    }
}

if (! function_exists('render_product_options_html')) {
    function render_product_options_html(array $productOptions, ?float $basePrice = null, bool $displayBasePrice = true): string
    {
        if (! EcommerceHelper::isEnabledProductOptions()) {
            return '';
        }

        $view = Theme::getThemeNamespace('views.ecommerce.options.render-options-html');

        if (! view()->exists($view)) {
            $view = 'plugins/ecommerce::themes.options.render-options-html';
        }

        return view($view, compact('productOptions', 'displayBasePrice', 'basePrice'))->render();
    }
}
