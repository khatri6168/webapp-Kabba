<?php

namespace Botble\Terms\Listeners;

use Botble\Base\Events\DeletedContentEvent;
use Exception;
use Botble\Base\Facades\MetaBox;

class DeletedContentListener
{
    public function handle(DeletedContentEvent $event): void
    {
        try {
            MetaBox::deleteMetaData($event->data, 'terms_schema_config');
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
