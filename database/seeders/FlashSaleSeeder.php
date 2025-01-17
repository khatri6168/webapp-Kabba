<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\FlashSale;
use Botble\Ecommerce\Models\Product;
use Illuminate\Support\Facades\DB;

class FlashSaleSeeder extends BaseSeeder
{
    public function run(): void
    {
        FlashSale::query()->truncate();
        DB::table('ec_flash_sale_products')->truncate();
        DB::table('ec_flash_sales_translations')->truncate();

        $flashSale = FlashSale::query()->create([
            'name' => 'Winter Sale',
            'end_date' => now()->addDays(30)->toDateString(),
        ]);

        for ($i = 1; $i <= 10; $i++) {
            $product = Product::query()->where('id', $i)->where('is_variation', 0)->first();

            if (! $product) {
                continue;
            }

            $price = $product->price;

            if ($product->front_sale_price !== $product->price) {
                $price = $product->front_sale_price;
            }

            $flashSale->products()->attach([$i => ['price' => $price - ($price * rand(10, 70) / 100), 'quantity' => rand(6, 20), 'sold' => rand(1, 5)]]);
        }

        $translations = [
            'Khuyến mãi mùa đông.',
        ];

        foreach ($translations as $index => $item) {
            DB::table('ec_flash_sales_translations')->insert([
                'lang_code' => 'vi',
                'ec_flash_sales_id' => $index + 1,
            ]);
        }
    }
}
