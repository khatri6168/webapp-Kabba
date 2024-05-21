<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\ProductCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCollectionSeeder extends BaseSeeder
{
    public function run(): void
    {
        ProductCollection::query()->truncate();

        $productCollections = [
            'New Arrival',
            'Best Sellers',
            'Special Offer',
        ];

        ProductCollection::query()->truncate();

        foreach ($productCollections as $item) {
            ProductCollection::query()->create([
                'name' => $item,
                'slug' => Str::slug($item),
            ]);
        }

        DB::table('ec_product_collections_translations')->truncate();

        $translations = [
            'Hàng mới về',
            'Bán chạy nhất',
            'Khuyến mãi đặc biệt',
        ];

        foreach ($translations as $index => $item) {
            DB::table('ec_product_collections_translations')->insert([
                'name' => $item,
                'lang_code' => 'vi',
                'ec_product_collections_id' => $index + 1,
            ]);
        }
    }
}
