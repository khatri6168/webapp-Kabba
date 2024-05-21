<?php

namespace Database\Seeders;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Supports\BaseSeeder;
use Botble\Team\Models\Team;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('teams');

        $teams = [
            [
                'name' => 'Paul Trueman',
                'title' => 'Chef',
                'location' => 'USA',
            ],
            [
                'name' => 'Emma Newman',
                'title' => 'Assistant chef',
                'location' => 'Qatar',
            ],
            [
                'name' => 'Oscar Oldman',
                'title' => 'Chef',
                'location' => 'India',
            ],
            [
                'name' => 'Ed Freeman',
                'title' => 'Assistant chef',
                'location' => 'China',
            ],
        ];

        Team::query()->truncate();
        DB::table('teams_translations')->truncate();

        foreach ($teams as $index => $item) {
            $item['photo'] = 'teams/' . ($index + 1) . '.png';
            $item['socials'] = json_encode([
                'facebook' => 'fb.com',
                'twitter' => 'twitter.com',
                'instagram' => 'instagram.com',
            ]);

            $item['status'] = BaseStatusEnum::PUBLISHED;

            Team::query()->create($item);
        }

        $translations = [
            [
                'name' => 'Paul Trueman',
                'title' => 'Đầu bếp',
                'location' => 'Mỹ',
            ],
            [
                'name' => 'Emma Newman',
                'title' => 'Phụ bếp',
                'location' => 'Qatar',
            ],
            [
                'name' => 'Oscar Oldman',
                'title' => 'Đầu bếp',
                'location' => 'Ấn độ',
            ],
            [
                'name' => 'Ed Freeman',
                'title' => 'Phụ bếp',
                'location' => 'Trung Quốc',
            ],
        ];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';
            $item['teams_id'] = $index + 1;

            DB::table('teams_translations')->insert($item);
        }
    }
}
