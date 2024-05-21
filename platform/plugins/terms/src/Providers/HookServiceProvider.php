<?php

namespace Botble\Terms\Providers;

use Botble\Base\Facades\Assets;
use Botble\Base\Facades\BaseHelper;
use Botble\Terms\Contracts\Terms as TermsContract;
use Botble\Terms\TermsCollection;
use Botble\Terms\TermsItem;
use Botble\Base\Facades\Html;
use Illuminate\Support\Arr;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Facades\MetaBox;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_action(BASE_ACTION_META_BOXES, function ($context, $object): void {
            if (! $object || $context != 'advanced') {
                return;
            }

            if (! in_array(get_class($object), config('plugins.terms.general.schema_supported', []))) {
                return;
            }

            if (! setting('enable_terms_schema', 0)) {
                return;
            }

            Assets::addStylesDirectly(['vendor/core/plugins/terms/css/terms.css'])
                ->addScriptsDirectly(['vendor/core/plugins/terms/js/terms.js']);

            MetaBox::addMetaBox(
                'terms_schema_config_wrapper',
                trans('plugins/terms::terms.terms_schema_config', [
                    'link' => Html::link(
                        'https://developers.google.com/search/docs/data-types/termspage',
                        trans('plugins/terms::terms.learn_more'),
                        ['target' => '_blank']
                    ),
                ]),
                function () {
                    $value = [];

                    $args = func_get_args();
                    if ($args[0] && $args[0]->id) {
                        $value = MetaBox::getMetaData($args[0], 'terms_schema_config', true);
                    }

                    $hasValue = ! empty($value);

                    $value = json_encode((array)$value);

                    return view('plugins/terms::schema-config-box', compact('value', 'hasValue'))->render();
                },
                get_class($object),
                $context
            );
        }, 39, 2);

        add_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, function ($screen, $object): void {
            add_filter(THEME_FRONT_HEADER, function ($html) use ($object): string|null {
                if (! in_array(get_class($object), config('plugins.terms.general.schema_supported', []))) {
                    return $html;
                }

                if (! setting('enable_terms_schema', 0)) {
                    return $html;
                }

                $value = MetaBox::getMetaData($object, 'terms_schema_config', true);

                if (! $value || ! is_array($value)) {
                    return $html;
                }

                foreach ($value as $key => $item) {
                    if (! $item[0]['value'] && ! $item[1]['value']) {
                        Arr::forget($value, $key);
                    }
                }

                $schemaItems = new TermsCollection();

                foreach ($value as $item) {
                    $schemaItems->push(
                        new TermsItem(BaseHelper::clean($item[0]['value']), BaseHelper::clean($item[1]['value']))
                    );
                }

                app(TermsContract::class)->registerSchema($schemaItems);

                return $html;
            }, 39);
        }, 39, 2);

        add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 59);

        add_filter('cms_settings_validation_rules', [$this, 'addSettingRules'], 59);
    }

    public function addSettingRules(array $rules): array
    {
        return array_merge($rules, [
            'enable_terms_schema' => 'nullable|in:0,1',
        ]);
    }

    public function addSettings(string|null $data = null): string
    {
        return $data . view('plugins/terms::settings')->render();
    }
}
