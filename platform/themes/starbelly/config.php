<?php

use Botble\Base\Facades\BaseHelper;
use Botble\Shortcode\View\View;
use Botble\Theme\Theme;

return [

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials" and "views"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these events can be overridden by package config.
    |
    */

    'events' => [

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function ($theme) {
            // You can remove this line anytime.
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function (Theme $theme) {
            // Partial composer.
            // $theme->partialComposer('header', function($view) {
            //     $view->with('auth', \Auth::user());
            // });

            if (BaseHelper::siteLanguageDirection() === 'rtl') {
                $theme->asset()->usePath()->add('bootstrap-css', 'plugins/bootstrap/css/bootstrap.rtl.min.css');
            } else {
                $theme->asset()->usePath()->add('bootstrap-css', 'plugins/bootstrap/css/bootstrap.min.css');
            }

            $theme->asset()->usePath()->add('font-awesome', 'plugins/font-awesome.min.css');
            $theme->asset()->usePath()->add('fancybox-css', 'plugins/fancybox.min.css');

            $theme->asset()->usePath()->add('style', 'css/style.css', ['swiper-css']);

            $theme->asset()->container('footer')->usePath()->add('jquery', 'plugins/jquery.min.js');
            $theme->asset()->container('footer')->usePath()->add('bootstrap-js', 'plugins/bootstrap/js/bootstrap.bundle.min.js');

            $theme->asset()->container('footer')->usePath()->add('sticky', 'plugins/sticky.js');
            $theme->asset()->container('footer')->usePath()->add('datepicker', 'plugins/datepicker.js');
            $theme->asset()->container('footer')->usePath()->add('fancybox', 'plugins/fancybox.min.js');
            $theme->asset()->container('footer')->usePath()->add('isotope', 'plugins/isotope.js');

            $theme->asset()->container('footer')->usePath()->add('script', 'js/script.js');
            $theme->asset()->container('footer')->usePath()->add('app', 'js/app.js');
            $theme->asset()->container('footer')->usePath()->add('ecommerce', 'js/ecommerce.js', ['jquery-bar-rating-js']);

            if (function_exists('shortcode')) {
                $theme->composer(['page', 'post', 'ecommerce.product'], function (View $view) {
                    $view->withShortcodes();
                });
            }
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => [

            'default' => function ($theme) {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
            },
        ],
    ],
];
