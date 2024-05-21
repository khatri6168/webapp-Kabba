<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Gallery\Models\Gallery as GalleryModel;
use Botble\Gallery\Models\GalleryMeta;
use Botble\Language\Models\LanguageMeta;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Botble\Slug\Facades\SlugHelper;

class GallerySeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('galleries');

        GalleryModel::query()->truncate();
        GalleryMeta::query()->truncate();
        DB::table('galleries_translations')->truncate();
        Slug::query()->where('reference_type', GalleryModel::class)->delete();
        MetaBoxModel::query()->where('reference_type', GalleryModel::class)->delete();
        LanguageMeta::query()->where('reference_type', GalleryModel::class)->delete();

        $galleries = [
            'Perfect',
            'New Day',
            'Happy Day',
            'Nature',
            'Morning',
            'Photography',
            'Summer',
            'Holiday',
            'Winter',
            'Warm',
        ];

        $images = [];
        for ($i = 0; $i < 9; $i++) {
            $images[] = [
                'img' => 'galleries/' . ($i + 1) . '.jpg',
                'description' => fake()->text(150),
            ];
        }

        foreach ($galleries as $index => $item) {
            $gallery = GalleryModel::query()->create([
                'user_id' => 1,
                'name' => $item,
                'is_featured' => rand(0, 1),
                'image' => 'galleries/' . ($index + 1) . '.jpg',
                'description' => fake()->realText(),
            ]);

            Slug::query()->create([
                'reference_type' => GalleryModel::class,
                'reference_id' => $gallery->id,
                'key' => Str::slug($gallery->name),
                'prefix' => SlugHelper::getPrefix(GalleryModel::class),
            ]);

            GalleryMeta::query()->create([
                'images' => $images,
                'reference_id' => $gallery->id,
                'reference_type' => GalleryModel::class,
            ]);
        }

        $translations = [
            'Hoàn hảo',
            'Ngày mới',
            'Ngày hạnh phúc',
            'Thiên nhiên',
            'Buổi sáng',
            'Nghệ thuật',
            'Mùa hè',
            'Kì nghỉ',
            'Mùa đông',
            'Ấm áp',
        ];

        foreach ($translations as $index => $item) {
            DB::table('galleries_translations')->insert([
                'lang_code' => 'vi',
                'galleries_id' => $index + 1,
            ]);
        }
    }
}
