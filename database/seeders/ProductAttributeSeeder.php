<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\ProductAttribute;
use Botble\Ecommerce\Models\ProductAttributeSet;
use Illuminate\Support\Facades\DB;

class ProductAttributeSeeder extends BaseSeeder
{
    public function run(): void
    {
        ProductAttributeSet::query()->truncate();

        ProductAttributeSet::query()->create([
            'title' => 'Color',
            'slug' => 'color',
            'display_layout' => 'visual',
            'is_searchable' => true,
            'is_use_in_product_listing' => true,
            'order' => 0,
        ]);

        ProductAttributeSet::query()->create([
            'title' => 'Weight',
            'slug' => 'weight',
            'display_layout' => 'text',
            'is_searchable' => true,
            'is_use_in_product_listing' => true,
            'order' => 0,
        ]);

        ProductAttribute::query()->truncate();

        $productAttributes = [
            [
                'attribute_set_id' => 1,
                'title' => 'Green',
                'slug' => 'green',
                'color' => '#5FB7D4',
                'is_default' => true,
                'order' => 1,
            ],
            [
                'attribute_set_id' => 1,
                'title' => 'Blue',
                'slug' => 'blue',
                'color' => '#333333',
                'is_default' => false,
                'order' => 2,
            ],
            [
                'attribute_set_id' => 1,
                'title' => 'Red',
                'slug' => 'red',
                'color' => '#DA323F',
                'is_default' => false,
                'order' => 3,
            ],
            [
                'attribute_set_id' => 1,
                'title' => 'Black',
                'slug' => 'back',
                'color' => '#2F366C',
                'is_default' => false,
                'order' => 4,
            ],
            [
                'attribute_set_id' => 1,
                'title' => 'Brown',
                'slug' => 'brown',
                'color' => '#87554B',
                'is_default' => false,
                'order' => 5,
            ],
            [
                'attribute_set_id' => 2,
                'title' => '1KG',
                'slug' => '1kg',
                'is_default' => true,
                'order' => 1,
            ],
            [
                'attribute_set_id' => 2,
                'title' => '2KG',
                'slug' => '2kg',
                'is_default' => false,
                'order' => 2,
            ],
            [
                'attribute_set_id' => 2,
                'title' => '3KG',
                'slug' => '3kg',
                'is_default' => false,
                'order' => 3,
            ],
            [
                'attribute_set_id' => 2,
                'title' => '4KG',
                'slug' => '4kg',
                'is_default' => false,
                'order' => 4,
            ],
            [
                'attribute_set_id' => 2,
                'title' => '5KG',
                'slug' => '5kg',
                'is_default' => false,
                'order' => 5,
            ],
        ];

        foreach ($productAttributes as $item) {
            ProductAttribute::query()->create($item);
        }

        if (is_plugin_active('language')) {
            DB::table('ec_product_attributes_translations')->truncate();
            DB::table('ec_product_attribute_sets_translations')->truncate();

            DB::table('ec_product_attribute_sets_translations')->insert([
                'title' => 'Màu sắc',
                'ec_product_attribute_sets_id' => 1,
                'lang_code' => 'vi',
            ]);

            DB::table('ec_product_attribute_sets_translations')->insert([
                'title' => 'Kích thước',
                'ec_product_attribute_sets_id' => 2,
                'lang_code' => 'vi',
            ]);

            $translations = [
                'Xanh lá cây',
                'Xanh da trời',
                'Đỏ',
                'Đen',
                'Nâu',
                '1KG',
                '2KG',
                '3KG',
                '4KG',
                '5KG',
            ];

            foreach ($translations as $index => $item) {
                DB::table('ec_product_attributes_translations')->insert([
                    'title' => $item,
                    'lang_code' => 'vi',
                    'ec_product_attributes_id' => $index + 1,
                ]);
            }
        }
    }
}
