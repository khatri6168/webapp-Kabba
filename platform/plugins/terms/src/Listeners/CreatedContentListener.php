<?php

namespace Botble\Terms\Listeners;

use Botble\Base\Events\CreatedContentEvent;
use Exception;
use Illuminate\Support\Arr;
use Botble\Base\Facades\MetaBox;

class CreatedContentListener
{
    public function handle(CreatedContentEvent $event): void
    {
        try {
            if ($event->request->has('content') && $event->request->has('terms_schema_config')) {
                $config = $event->request->input('terms_schema_config');
                if (! empty($config)) {
                    foreach ($config as $key => $item) {
                        if (! $item[0]['value'] && ! $item[1]['value']) {
                            Arr::forget($config, $key);
                        }
                    }
                }

                if (empty($config)) {
                    MetaBox::deleteMetaData($event->data, 'terms_schema_config');
                } else {
                    MetaBox::saveMetaBoxData($event->data, 'terms_schema_config', $config);
                }
            }
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
