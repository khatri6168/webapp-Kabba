<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Testimonial\Models\Testimonial;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Botble\Base\Facades\MetaBox;

class TestimonialSeeder extends BaseSeeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Wade Warren',
                'company' => 'Louis Vuitton',
            ],
            [
                'name' => 'Brooklyn Simmons',
                'company' => 'Nintendo',
            ],
            [
                'name' => 'Jenny Wilson',
                'company' => 'Starbucks',
            ],
            [
                'name' => 'Albert Flores',
                'company' => 'Bank of America',
            ],
        ];

        Testimonial::query()->truncate();
        DB::table('testimonials_translations')->truncate();
        MetaBoxModel::query()->where('reference_type', Testimonial::class)->delete();

        foreach ($testimonials as $index => $item) {
            $testimonial = Testimonial::query()->create(array_merge($item, [
                'image' => 'customers/' . ($index + 1) . '.jpg',
                'content' => fake()->text(rand(200, 500)),
            ]));

            MetaBox::saveMetaBoxData($testimonial, 'title', Arr::get($item, 'title'));
        }

        $translations = [];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';
            $item['testimonials_id'] = $index + 1;

            DB::table('testimonials_translations')->insert(Arr::except($item, ['title']));

            MetaBox::saveMetaBoxData(Testimonial::query()->find($item['testimonials_id']), $item['lang_code'] . '_title', Arr::get($item, 'title'));
        }
    }
}
