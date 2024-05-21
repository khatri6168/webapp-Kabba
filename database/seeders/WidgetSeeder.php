<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Widget\Models\Widget;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Theme;

class WidgetSeeder extends BaseSeeder
{
    public function run(): void
    {
        Widget::query()->truncate();

        $widgets = [
            [
                'widget_id' => 'ContactInformation',
                'sidebar_id' => 'information-sidebar',
                'position' => 1,
                'data' => [
                    'id' => 'ContactInformation',
                    'title' => 'Contact Information',
                    'phone' => '0123456789',
                    'email' => 'contact@archielite.com',
                    'address' => 'Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678.',
                    'working_hours_start' => '08:00',
                    'working_hours_end' => '17:00',
                ],
            ],
            [
                'widget_id' => 'GalleryWidget',
                'sidebar_id' => 'information-sidebar',
                'position' => 2,
                'data' => [
                    'id' => 'GalleryWidget',
                    'title_gallery' => 'Instagram',
                    'number_image' => 6,

                ],
            ],
            [
                'widget_id' => 'BlogPostsWidget',
                'sidebar_id' => 'information-sidebar',
                'position' => 3,
                'data' => [
                    'id' => 'BlogPostsWidget',
                    'title' => 'Latest publications',
                    'limit' => 3,
                    'style' => 'in-sidebar',
                ],
            ],
            [
                'widget_id' => 'BlogPostsWidget',
                'sidebar_id' => 'blog-footer',
                'position' => 1,
                'data' => [
                    'id' => 'BlogPostsWidget',
                    'title' => 'Most popular Publication',
                    'description' => 'From Our blog and Event Fanpage',
                    'limit' => 5,
                ],
            ],
            [
                'widget_id' => 'BlogSearchWidget',
                'sidebar_id' => 'blog-sidebar',
                'position' => 1,
                'data' => [
                    'name' => 'Search',
                ],
            ],
            [
                'widget_id' => 'BlogCategoriesWidget',
                'sidebar_id' => 'blog-sidebar',
                'position' => 2,
                'data' => [
                    'name' => 'Categories',
                    'limit' => 5,
                ],
            ],
            [
                'widget_id' => 'BlogTagsWidget',
                'sidebar_id' => 'blog-sidebar',
                'position' => 3,
                'data' => [
                    'name' => 'Keywords',
                    'limit' => 10,
                ],
            ],
            [
                'widget_id' => 'AppDownloadWidget',
                'sidebar_id' => 'galleries_sidebar',
                'position' => 1,
                'data' => [
                    'title' => 'Download our mobile app.',
                    'subtitle' => 'Consecrate numeral port nemo intelligentsia rem disciple quo mod.',
                    'image' => 'backgrounds/phones.png',
                    'platform_name_1' => 'App Store',
                    'platform_button_image_1' => 'platforms/ios.png',
                    'platform_url_1' => '#',
                    'platform_name_2' => 'GooglePlay',
                    'platform_button_image_2' => 'platforms/android.png',
                    'platform_url_2' => '#',
                ],
            ],
            [
                'widget_id' => 'CallToActionWidget',
                'sidebar_id' => 'product-footer',
                'position' => 1,
                'data' => [
                    'title' => 'Free delivery service.',
                    'description' => '*Consectetur numquam poro nemo veniam<br>eligendi rem adipisci quo modi.',
                    'image' => 'illustrations/delivery.png',
                    'button_primary_url' => '#',
                    'button_primary_label' => 'Order delivery',
                    'button_primary_icon' => 'general/cart.png',
                    'button_secondary_url' => '#',
                    'button_secondary_label' => 'Menu',
                    'button_secondary_icon' => 'general/menu.png',
                ],
            ],
            [
                'widget_id' => 'NewsletterWidget',
                'sidebar_id' => 'pre_footer_sidebar',
                'position' => 1,
                'data' => [
                    'title' => 'Subscribe our newsletter',
                    'subtitle' => 'Subscribe to get latest updates and information',
                    'image' => 'illustrations/envelope-1.png',
                ],
            ],
        ];

        $theme = Theme::getThemeName();

        $trans = [
            'vi' => [],
        ];

        $locales = ['en_US', 'vi'];

        foreach ($widgets as $widget) {
            foreach ($locales as $locale) {
                $widget['theme'] = $locale == 'en_US' ? $theme : ($theme . '-' . $locale);

                foreach ($widget['data'] as $key => $value) {
                    if ($key == 'id') {
                        continue;
                    }

                    if ($key == 'menu_id') {
                        $widget['data'][$key] = Str::slug($widget['data']['name']);

                        continue;
                    }

                    $widget['data'][$key] = Arr::get($trans, $locale . '.' . $value, $value);
                }
                Widget::query()->create($widget);
            }
        }
    }
}
