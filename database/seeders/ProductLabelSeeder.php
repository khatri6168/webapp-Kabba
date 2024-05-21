<?php

namespace Database\Seeders;

use Botble\Ecommerce\Models\ProductLabel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductLabelSeeder extends Seeder
{
    public function run(): void
    {
        ProductLabel::query()->truncate();

        $productCollections = [
            [
                'name' => 'Hot',
                'color' => '#ec2434',
            ],
            [
                'name' => 'New',
                'color' => '#00c9a7',
            ],
            [
                'name' => 'Sale',
                'color' => '#fe9931',
            ],
        ];

        foreach ($productCollections as $item) {
            ProductLabel::query()->create($item);
        }

        DB::table('ec_product_labels_translations')->truncate();

        $translations = [
            'Nổi bật',
            'Mới',
            'Giảm giá',
        ];

        foreach ($translations as $index => $item) {
            DB::table('ec_product_labels_translations')->insert([
                'name' => $item,
                'lang_code' => 'vi',
                'ec_product_labels_id' => $index + 1,
            ]);
        }
    }
}
