<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\Brand;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Botble\Slug\Facades\SlugHelper;

class BrandSeeder extends BaseSeeder
{
    protected array $trans = [];

    public function run(): void
    {
        $this->uploadFiles('brands');

        Brand::query()->truncate();
        Slug::query()->where('reference_type', Brand::class)->delete();

        $brands = [
            'Nestlé',
            'Pepsi',
            'McDonald\'s',
            'Burger King',
            'KFC',
            'Starbucks',
            'Popeyes',
            'Phúc Long',
        ];

        foreach ($brands as $key => $item) {
            $brand = Brand::query()->create([
                'order' => $key,
                'is_featured' => rand(0, 1),
                'name' => $item,
                'logo' => 'brands/' . $key + 1 . '.png',
                'description' => fake()->text(),
                'website' => fake()->url(),
            ]);

            Slug::query()->create([
                'reference_type' => Brand::class,
                'reference_id' => $brand->id,
                'key' => Str::slug($brand->name),
                'prefix' => SlugHelper::getPrefix(Brand::class),
            ]);
        }

        DB::table('ec_brands_translations')->truncate();

        $translations = [];

        foreach ($translations as $index => $item) {
            DB::table('ec_brands_translations')->insert([
                'name' => $item,
                'description' => fake('vi-VN')->realText(),
                'lang_code' => 'vi',
                'ec_brands_id' => $index + 1,
            ]);
        }
    }
}
