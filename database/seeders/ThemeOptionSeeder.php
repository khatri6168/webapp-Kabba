<?php

namespace Database\Seeders;

use BaseHelper;
use Botble\Base\Models\BaseModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Setting\Models\Setting;
use Illuminate\Support\Arr;

class ThemeOptionSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('general');
        $this->uploadFiles('backgrounds');

        $theme = Arr::first(BaseHelper::scanFolder(theme_path()));

        Setting::query()->where('key', 'LIKE', 'theme-' . $theme . '-%')->delete();
        Setting::query()->whereIn('key', ['theme', 'admin_favicon', 'admin_logo'])->delete();

        $settings = [
            'theme' => $theme,
            'admin_favicon' => 'general/favicon.png',
            'admin_logo' => 'general/logo-light.png',
        ];

        foreach ($settings as $key => $value) {
            $item = [
                'key' => $key,
                'value' => $value,
            ];

            if (BaseModel::determineIfUsingUuidsForId()) {
                $item['id'] = BaseModel::newUniqueId();
            }

            Setting::query()->insertOrIgnore($item);
        }

        $data = [
            'site_title' => 'StarBelly - Restaurant & Cafe Laravel Script',
            'seo_description' => 'StarBelly is a Restaurant & Cafe Laravel Script. It is a powerful, clean, modern, and fully responsive template. It is designed for agency, business, corporate, creative, freelancer, portfolio, photography, personal, resume, and any kind of creative fields.',
            'copyright' => '© ' . now()->format('Y') . ' Archi Elite JSC. All Rights Reserved.',
            'homepage_id' => '1',
            'blog_page_id' => '3',
            'favicon' => 'general/favicon.png',
            'logo' => 'general/logo.png',
            'seo_og_image' => 'general/open-graph-image.png',
            'action_button_text' => 'Contact Us',
            'action_button_url' => '/contact',
            'cookie_consent_message' => 'Your experience on this site will be improved by allowing cookies ',
            'cookie_consent_learn_more_url' => '/cookie-policy',
            'cookie_consent_learn_more_text' => 'Cookie Policy',
            'cookie_consent_learn_abc_more_text' => 'ABC',
            'background_post_single' => 'general/bg-post.png',
            'address' => '66 avenue des Champs, 75008, Paris, France',
            'hotline' => '(+01) - 456 789',
            'email' => 'contact@agon.com',
            'login_page_image' => 'general/login.png',
            'register_page_images' => json_encode(['general/register-1.png', 'general/register-2.png', 'general/register-3.png', 'general/register-4.png', 'general/register-5.png']),
            'primary_color' => '#F5C332',
            'secondary_color' => '#8D99AE',
            'danger_color' => '#EF476F',
            'primary_font' => 'Rubik',
            'top_bar_color' => '#F5C332',
            'gallery_page_style' => 1,
            'gallery_page_detail_style' => 1,
            'gallery_page_title' => 'It’s a pity that the photo does not convey the taste!',
            'gallery_page_description' => 'Consecrate numeral port nemo intelligentsia rem disciple quo mod.',
            'gallery_breadcrumb_title' => 'It’s a pity that the photo does not convey the taste!',
            'gallery_breadcrumb_subtitle' => 'Consecrate numeral port nemo venial diligent rem disciple quo mod.',
            'background_image_page_404' => 'illustrations/man.png',
            'max_filter_price' => 1000,
            'background_breadcrumb_default' => 'backgrounds/breadcrumb-default.jpg',
            'social_links' => json_encode([
                [
                    [
                        'key' => 'social-name',
                        'value' => 'Facebook',
                    ],
                    [
                        'key' => 'social-icon',
                        'value' => 'fab fa-facebook-f',
                    ],
                    [
                        'key' => 'social-url',
                        'value' => 'https://www.facebook.com/',
                    ],
                ],
                [
                    [
                        'key' => 'social-name',
                        'value' => 'Twitter',
                    ],
                    [
                        'key' => 'social-icon',
                        'value' => 'fab fa-twitter',
                    ],
                    [
                        'key' => 'social-url',
                        'value' => 'https://www.twitter.com/',
                    ],
                ],
                [
                    [
                        'key' => 'social-name',
                        'value' => 'Instagram',
                    ],
                    [
                        'key' => 'social-icon',
                        'value' => 'fab fa-instagram',
                    ],
                    [
                        'key' => 'social-url',
                        'value' => 'https://www.instagram.com/',
                    ],
                ],
                [
                    [
                        'key' => 'social-name',
                        'value' => 'Youtube',
                    ],
                    [
                        'key' => 'social-icon',
                        'value' => 'fab fa-youtube',
                    ],
                    [
                        'key' => 'social-url',
                        'value' => 'https://www.youtube.com/',
                    ],
                ],
            ]),
        ];

        foreach ($data as $key => $value) {
            $item = [
                'key' => 'theme-' . $theme . '-' . $key,
                'value' => $value,
            ];

            if (BaseModel::determineIfUsingUuidsForId()) {
                $item['id'] = BaseModel::newUniqueId();
            }

            Setting::query()->insertOrIgnore($item);
        }
    }
}
