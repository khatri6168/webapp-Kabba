<?php

namespace Database\Seeders;

use Botble\Setting\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::query()->whereIn('key', ['media_random_hash'])->delete();

        Setting::query()->insertOrIgnore([
            [
                'key' => 'media_random_hash',
                'value' => md5(time()),
            ],
        ]);
    }
}
