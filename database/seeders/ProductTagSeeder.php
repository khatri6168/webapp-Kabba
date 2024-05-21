<?php

namespace Database\Seeders;

use Botble\Ecommerce\Models\ProductTag;
use Botble\Slug\Models\Slug;
use Botble\Base\Supports\BaseSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Botble\Slug\Facades\SlugHelper;

class ProductTagSeeder extends BaseSeeder
{
    public function run(): void
    {
        ProductTag::query()->truncate();
        Slug::query()->where('reference_type', ProductTag::class)->delete();

        $tags = [
            'Dinner',
            'Delicious',
            'Breakfast',
            'Chocolate',
            'Vegan',
            'Sweet',
        ];

        foreach ($tags as $item) {
            $tag = ProductTag::query()->create([
                'name' => $item,
            ]);

            Slug::query()->create([
                'reference_type' => ProductTag::class,
                'reference_id' => $tag->id,
                'key' => Str::slug($tag->name),
                'prefix' => SlugHelper::getPrefix(ProductTag::class),
            ]);
        }

        DB::table('ec_product_tags_translations')->truncate();

        $translations = [
            'Dinner',
            'Delicious',
            'Breakfast',
            'Chocolate',
            'Vegan',
            'Sweet',
        ];

        foreach ($translations as $index => $item) {
            DB::table('ec_product_tags_translations')->insert([
                'name' => $item,
                'lang_code' => 'vi',
                'ec_product_tags_id' => $index + 1,
            ]);
        }
    }
}
