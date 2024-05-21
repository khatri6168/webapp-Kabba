<?php

namespace Botble\AppApi\Providers;

use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\Facades\Cookie;
use Botble\Base\Supports\ServiceProvider;
use Botble\Theme\Facades\Theme;

class AppApiServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('plugins/app-api')
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->publishAssets()
            ->loadRoutes();

        if (defined('THEME_FRONT_FOOTER') && theme_option('cookie_consent_enable', 'yes') == 'yes') {
            $this->app->resolving(EncryptCookies::class, function (EncryptCookies $encryptCookies) {
                $encryptCookies->disableFor(config('plugins.AppApi.general.cookie_name'));
            });

            $this->app['view']->composer('plugins/AppApi::index', function (View $view) {
                $cookieConsentConfig = config('plugins.AppApi.general', []);

                $alreadyConsentedWithCookies = Cookie::has($cookieConsentConfig['cookie_name'] ?? 'cookie_for_consent');

                $view->with(compact('alreadyConsentedWithCookies', 'cookieConsentConfig'));
            });

            if (! Cookie::has(config('plugins.AppApi.general.cookie_name'))) {
                Theme::asset()
                    ->usePath(false)
                    ->add(
                        'AppApi-css',
                        asset('vendor/core/plugins/AppApi/css/AppApi.css'),
                        [],
                        [],
                        '1.0.1'
                    );
                Theme::asset()
                    ->container('footer')
                    ->usePath(false)
                    ->add(
                        'AppApi-js',
                        asset('vendor/core/plugins/AppApi/js/AppApi.js'),
                        ['jquery'],
                        [],
                        '1.0.1'
                    );
            }

           // add_filter(THEME_FRONT_FOOTER, [$this, 'registerCookieConsent'], 1346);
        }

        theme_option()
            ->setSection([
                'title' => trans('plugins/AppApi::AppApi.theme_options.name'),
                'desc' => trans('plugins/AppApi::AppApi.theme_options.description'),
                'id' => 'opt-text-subsection-AppApi',
                'subsection' => true,
                'icon' => 'fas fa-cookie-bite',
                'priority' => 9999,
                'fields' => [
                    [
                        'id' => 'cookie_consent_enable',
                        'type' => 'customSelect',
                        'label' => trans('plugins/AppApi::AppApi.theme_options.enable'),
                        'attributes' => [
                            'name' => 'cookie_consent_enable',
                            'list' => [
                                'yes' => trans('core/base::base.yes'),
                                'no' => trans('core/base::base.no'),
                            ],
                            'value' => 'yes',
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                    [
                        'id' => 'cookie_consent_style',
                        'type' => 'customSelect',
                        'label' => trans('plugins/AppApi::AppApi.theme_options.style'),
                        'attributes' => [
                            'name' => 'cookie_consent_style',
                            'list' => [
                                'full-width' => trans('plugins/AppApi::AppApi.theme_options.full_width'),
                                'minimal' => trans('plugins/AppApi::AppApi.theme_options.minimal'),
                            ],
                            'value' => 'yes',
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                    [
                        'id' => 'cookie_consent_message',
                        'type' => 'text',
                        'label' => trans('plugins/AppApi::AppApi.theme_options.message'),
                        'attributes' => [
                            'name' => 'cookie_consent_message',
                            'value' => trans('plugins/AppApi::AppApi.message'),
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => trans('plugins/AppApi::AppApi.theme_options.message'),
                                'data-counter' => 400,
                            ],
                        ],
                    ],

                    [
                        'id' => 'cookie_consent_button_text',
                        'type' => 'text',
                        'label' => trans('plugins/AppApi::AppApi.theme_options.button_text'),
                        'attributes' => [
                            'name' => 'cookie_consent_button_text',
                            'value' => trans('plugins/AppApi::AppApi.button_text'),
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => trans('plugins/AppApi::AppApi.theme_options.button_text'),
                                'data-counter' => 120,
                            ],
                        ],
                    ],

                    [
                        'id' => 'cookie_consent_learn_more_url',
                        'type' => 'text',
                        'label' => trans('plugins/AppApi::AppApi.theme_options.learn_more_url'),
                        'attributes' => [
                            'name' => 'cookie_consent_learn_more_url',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => trans('plugins/AppApi::AppApi.theme_options.learn_more_url'),
                                'data-counter' => 120,
                            ],
                        ],
                    ],

                    [
                        'id' => 'cookie_consent_learn_more_text',
                        'type' => 'text',
                        'label' => trans('plugins/AppApi::AppApi.theme_options.learn_more_text'),
                        'attributes' => [
                            'name' => 'cookie_consent_learn_more_text',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => trans('plugins/AppApi::AppApi.theme_options.learn_more_text'),
                                'data-counter' => 120,
                            ],
                        ],
                    ],

                    [
                        'id' => 'cookie_consent_background_color',
                        'type' => 'customColor',
                        'label' => trans('plugins/AppApi::AppApi.theme_options.background_color'),
                        'attributes' => [
                            'name' => 'cookie_consent_background_color',
                            'value' => '#000',
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => trans('plugins/AppApi::AppApi.theme_options.background_color'),
                            ],
                        ],
                    ],

                    [
                        'id' => 'cookie_consent_text_color',
                        'type' => 'customColor',
                        'label' => trans('plugins/AppApi::AppApi.theme_options.text_color'),
                        'attributes' => [
                            'name' => 'cookie_consent_text_color',
                            'value' => '#fff',
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => trans('plugins/AppApi::AppApi.theme_options.text_color'),
                            ],
                        ],
                    ],

                    [
                        'id' => 'cookie_consent_max_width',
                        'type' => 'number',
                        'label' => trans('plugins/AppApi::AppApi.theme_options.max_width'),
                        'attributes' => [
                            'name' => 'cookie_consent_max_width',
                            'value' => 1170,
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => trans('plugins/AppApi::AppApi.theme_options.max_width'),
                            ],
                        ],
                    ],
                ],
            ]);
    }

    // public function registerCookieConsent(string|null $html): string
    // {
    //     if (is_in_admin()) {
    //         return $html;
    //     }

    //     return $html . view('plugins/AppApi::index')->render();
    // }
}
