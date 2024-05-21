<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Botble\Slug\Facades\SlugHelper;

class ProductCategorySeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('product-categories');

        ProductCategory::query()->truncate();
        DB::table('ec_product_categories_translations')->truncate();
        Slug::query()->where('reference_type', ProductCategory::class)->delete();
        MetaBoxModel::query()->where('reference_type', ProductCategory::class)->delete();

        $categories = [
            'Starters',
            'Main dishes',
            'Drinks',
            'Desserts',
        ];

        foreach ($categories as $index => $item) {
            $category = ProductCategory::query()->create([
                'name' => $item,
                'is_featured' => rand(0, 1),
                'order' => $index,
                'description' => fake()->realText(),
                'image' => 'product-categories/' . ($index + 1) . '.png',
            ]);

            Slug::query()->create([
                'reference_type' => ProductCategory::class,
                'reference_id' => $category->id,
                'key' => Str::slug($category->name),
                'prefix' => SlugHelper::getPrefix(ProductCategory::class),
            ]);
        }

        $translations = [];

        foreach ($translations as $key => $translation) {
            DB::table('ec_product_categories_translations')->insert([
                'name' => $translation,
                'lang_code' => 'vi',
                'ec_product_categories_id' => $key + 1,
                'description' => fake('vi-VN')->realText(),
            ]);
        }
    }
}
