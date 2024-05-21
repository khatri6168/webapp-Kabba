<?php

namespace Botble\Terms;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Botble\Setting\Facades\Setting;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('terms_categories');
        Schema::dropIfExists('terms');
        Schema::dropIfExists('terms_categories_translations');
        Schema::dropIfExists('terms_translations');

        Setting::delete([
            'enable_terms_schema',
        ]);
    }
}
