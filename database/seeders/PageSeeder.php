<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;
use Botble\Base\Facades\Html;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Botble\Base\Facades\MetaBox;
use Botble\Slug\Facades\SlugHelper;

class PageSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('backgrounds');
        $this->uploadFiles('platforms');

        Page::query()->truncate();
        DB::table('pages_translations')->truncate();
        Slug::query()->where('reference_type', Page::class)->delete();
        MetaBoxModel::query()->where('reference_type', Page::class)->delete();
        LanguageMeta::query()->where('reference_type', Page::class)->delete();

        $pages = [
            [
                'name' => 'Homepage 1',
                'content' =>
                    Html::tag('div', '[hero-banner style="1" title="We do not cook, we create your emotions!" subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." text_secondary="Hi, new friend!" image="backgrounds/girl.png" button_label_1="Our menu" button_url_1="/shop-1" button_label_2="About us" button_url_2="/about-us"][/hero-banner]') .
                    Html::tag('div', '[our-features title="We are doing more than you expect" title_1="We are located in the city center" subtitle_1="Porto nemo venial necessitates presentiment diligent rem temporise disciple quo mod numeral." title_2="Fresh, organic ingredients" subtitle_2="Consectetur numquam porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi." title_3="Own fast delivery" subtitle_3="Necessitatibus praesentium eligendi rem temporibus adipisci quo modi. Lorem ipsum dolor sit." image="backgrounds/interior.jpg" year_experience="2"][/our-features]') .
                    Html::tag('div', '[featured-categories title="What do you like today?" subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." category_ids="1,2,3,4" button_label="Shop now" button_url="/shop-1"][/featured-categories]') .
                    Html::tag('div', '[products-list title="Most popular dishes" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." type="feature" style="slide" items_on_slide="3" limit="6" footer_style="rating" button_label="Shop now" button_url="/shop-1" button_icon="general/menu.png"][/products-list]') .
                    Html::tag('div', '[team title="They will cook for you" subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." team_ids="1,2,3,4" limit="4" button_label="Open menu" button_icon="general/menu.png" button_url="/shop-1"][/team]') .
                    Html::tag('div', '[apps-download title="Download our mobile app." subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." image="backgrounds/phones.png" platform_button_image_1="platforms/android.png" platform_url_1="https://play.google.com/store" platform_button_image_2="platforms/ios.png" platform_url_2="https://www.apple.com/store"][/apps-download]') .
                    Html::tag('div', '[flash-sale-popup flash_sale_ids="1" description="Et modi itaque praesentium" timeout="5"][/flash-sale-popup]')
                ,
                'template' => 'homepage',
            ],
            [
                'name' => 'Homepage 2',
                'content' =>
                    Html::tag('div', htmlentities('[hero-banner style="2" title="We do not cook, we create your emotions!" subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." text_secondary="Hi, new friend!" image_1="illustrations/1.png" image_2="illustrations/2.png" image_3="illustrations/3.png" message_1="<span>😋</span> Om-nom-nom..." message_2="<span>🥰</span> Sooooo delicious!" button_label_1="Our menu" button_url_1="#" button_label_2="About us" button_url_2="#"][/hero-banner]')) .
                    Html::tag('div', htmlentities('[about-text image="galleries/2.jpg" experience_year="17" experience_text="Years Experience" title="We are doing more than you expect" text="Faudantium magnam error temporibus ipsam aliquid neque quibusdam dolorum, quia ea numquam assumenda mollitia dolorem impedit. Voluptate at quis exercitationem officia temporibus adipisci quae totam enim dolorum, assumenda. Sapiente soluta nostrum reprehenderit a velit obcaecati facilis vitae magnam tenetur neque vel itaque inventore eaque explicabo commodi maxime! Aliquam quasi, voluptates odio. Consectetur adipisicing elit. <br><br> Cupiditate nesciunt amet facilis numquam, nam adipisci qui voluptate voluptas enim obcaecati veritatis animi nulla, mollitia commodi quaerat ex, autem ea laborum." text_image="general/signature.png"][/about-text]')) .
                    Html::tag('div', '[features title_1="We are located in the city center" description_1="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam." title_2="Fresh ingredients from organic farms" description_2="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam." title_3="Own fast delivery. 30 min Maximum" description_3="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam." title_4="Professional, experienced chefs" description_4="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam." title_5="The highest standards of service" description_5="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam."][/features]') .
                    Html::tag('div', '[products-list title="Most popular dishes" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." type="trending" style="slide" items_per_row="3" limit="5" footer_style="rating" button_label="Shop now" button_url="/shop-2" button_icon="general/menu.png"][/products-list]') .
                    Html::tag('div', '[testimonials title="Reviews about us" description="Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." limit="5" button_url="#" button_label="All reviews" button_icon="general/dialog.png"][/testimonials]') .
                    Html::tag('div', '[call-to-action title="Free delivery service." description="Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." image="illustrations/delivery.png" button_primary_url="#" button_primary_label="Order delivery" button_primary_icon="general/cart.png" button_secondary_url="#" button_secondary_label="Menu" button_secondary_icon="general/menu.png"][/call-to-action]')
                ,
                'template' => 'homepage',
            ],
            [
                'name' => 'Homepage 3',
                'content' =>
                    Html::tag('div', '[featured-categories category_ids="1,2,3,4" style="1"][/featured-categories]') .
                    Html::tag('div', '[products-list title="Most popular dishes" subtitle="Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." type="trending" style="slide" items_per_row="4" limit="6" footer_style="add-to-cart" button_label="Shop now" button_url="/shop-1" button_icon="general/arrow.png"][/products-list]') .
                    Html::tag('div', '[products-list title="Our Bestsellers" subtitle="Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." type="feature" style="slide" items_per_row="4" limit="6" footer_style="add-to-cart" button_label="View all" button_url="/shop-1" button_icon="general/arrow.png"][/products-list]') .
                    Html::tag('div', '[team title="They will cook for you" subtitle="Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." team_ids="1,2,3,4" limit="4" button_label="More about us" button_icon="general/arrow.png"][/team]') .
                    Html::tag('div', '[promo title_left="-50%" subtitle_left="Discount for all* burgers!" description_left="*Et modi itaque praesentium." image_left="illustrations/burger.png" button_label_left="Get it now" button_url_left="/products" title_right="Visit Starbelly and get your coffee*" subtitle_right="For free!" description_right="*Et modi itaque praesentium." image_right="illustrations/cup.png" button_label_right="Get it now" button_url_right="#"][/promo]')
                ,
            ],
            [
                'name' => 'Homepage 4',
                'content' =>
                    Html::tag('div', '[featured-categories category_ids="1,2,3,4" style="2"][/featured-categories]') .
                    Html::tag('div', '[products-list title="Most popular dishes" subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." type="feature" style="slide" items_per_row="3" limit="6" footer_style="add-to-cart" button_label="View all" button_url="#" button_icon="general/arrow.png"][/products-list]') .
                    Html::tag('div', '[call-to-action title="-50% Discount for all* burgers!" description="*Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." image="illustrations/burger-2.png" style_image="product" button_primary_url="#" button_primary_label="Get it now!" button_primary_icon="general/cart.png" button_secondary_url="#" button_secondary_label="Menu" button_secondary_icon="general/menu.png"][/call-to-action]') .
                    Html::tag('div', '[products-list title="Our Bestsellers" subtitle="Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." type="trending" style="slide" items_per_row="3" limit="6" footer_style="add-to-cart" button_label="View all" button_url="#" button_icon="general/arrow.png"][/products-list]') .
                    Html::tag('div', '[team title="They will cook for you" subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." team_ids="1,2,3" button_label="More about us" button_url="/about-us" button_icon="general/arrow.png"][/team]') .
                    Html::tag('div', '[call-to-action title="Free delivery service." description="Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." image="illustrations/delivery.png" button_primary_url="#" button_primary_label="Order delivery" button_primary_icon="general/cart.png" button_secondary_url="/shop-1" button_secondary_label="Menu" button_secondary_icon="general/menu.png"][/call-to-action]')
                ,
                'metabox' => [
                    'breadcrumb_style' => 'expanded',
                    'breadcrumb_title' => 'Taste the dishes of the restaurant without leaving home.',
                    'breadcrumb_subtitle' => 'Consecrate numeral port nemo venial diligent rem disciple quo mod.',
                ],
            ],
            [
                'name' => 'About Us',
                'content' =>
                    Html::tag('div', '[about-text image="blog/post-3.jpg" experience_year="17" experience_text="Years Experience" title="We are doing more than you expect" text="Faudantium magnam error temporibus ipsam aliquid neque quibusdam dolorum, quia ea numquam assumenda mollitia dolorem impedit. Voluptate at quis exercitationem officia temporibus adipisci quae totam enim dolorum, assumenda. Sapiente soluta nostrum reprehenderit a velit obcaecati facilis vitae magnam tenetur neque vel itaque inventore eaque explicabo commodi maxime! Aliquam quasi, voluptates odio. Consectetur adipisicing elit. <br><br> Cupiditate nesciunt amet facilis numquam, nam adipisci qui voluptate voluptas enim obcaecati veritatis animi nulla, mollitia commodi quaerat ex, autem ea laborum." text_image="general/signature.png"][/about-text]') .
                    Html::tag('div', '[features title_1="We are located in the city center" description_1="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam." title_2="Fresh ingredients from organic farms" description_2="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam." title_3="Own fast delivery. 30 min Maximum" description_3="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam." title_4="Professional, experienced chefs" description_4="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam." title_5="The highest standards of service" description_5="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam."][/features]') .
                    Html::tag('div', htmlentities('[video badge_text="Promo video" title="Restaurant is like a theater. <br>Our task is to amaze you!" description="Repellat, dolorem a. Qui ipsam quos, obcaecati mollitia consectetur ad vero minus neque sit architecto totam distineserunt pariatur adipisci rem aspernatur illum ex!" video_thumbnail="illustrations/interior-2.jpg" video_url="https://www.youtube.com/watch?v=F3zw1Gvn4Mk" play_button_label="Promo video"][/video]')) .
                    Html::tag('div', '[team title="They will cook for you" subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." team_ids="1,2,3,4" button_label="View Shop" button_icon="general/menu.png" button_url="/shop-2"][/team]') .
                    Html::tag('div', '[testimonials title="Reviews about us" description="Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." limit="5" button_url="reviews" button_label="All reviews" button_icon="general/dialog.png"][/testimonials]') .
                    Html::tag('div', '[call-to-action title="Free delivery service." description="Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." image="illustrations/delivery.png" button_primary_url="#" button_primary_label="Order delivery" button_primary_icon="general/cart.png" button_secondary_url="#" button_secondary_label="Menu" button_secondary_icon="general/menu.png"][/call-to-action]')
                ,
            ],
            [
                'name' => 'About Us 2',
                'content' =>
                    Html::tag('div', '[about-text image="blog/post-3.jpg" experience_year="17" experience_text="Years Experience" title="We are doing more than you expect" text="Faudantium magnam error temporibus ipsam aliquid neque quibusdam dolorum, quia ea numquam assumenda mollitia dolorem impedit. Voluptate at quis exercitationem officia temporibus adipisci quae totam enim dolorum, assumenda. Sapiente soluta nostrum reprehenderit a velit obcaecati facilis vitae magnam tenetur neque vel itaque inventore eaque explicabo commodi maxime! Aliquam quasi, voluptates odio. Consectetur adipisicing elit. <br><br> Cupiditate nesciunt amet facilis numquam, nam adipisci qui voluptate voluptas enim obcaecati veritatis animi nulla, mollitia commodi quaerat ex, autem ea laborum." text_image="general/signature.png"][/about-text]') .
                    Html::tag('div', '[features title_1="We are located in the city center" description_1="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam." title_2="Fresh ingredients from organic farms" description_2="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam." title_3="Own fast delivery. 30 min Maximum" description_3="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam." title_4="Professional, experienced chefs" description_4="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam." title_5="The highest standards of service" description_5="Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam."][/features]') .
                    Html::tag('div', htmlentities('[video badge_text="Promo video" title="Restaurant is like a theater. <br>Our task is to amaze you!" description="Repellat, dolorem a. Qui ipsam quos, obcaecati mollitia consectetur ad vero minus neque sit architecto totam distineserunt pariatur adipisci rem aspernatur illum ex!" video_thumbnail="illustrations/interior-2.jpg" video_url="https://www.youtube.com/watch?v=F3zw1Gvn4Mk" play_button_label="Promo video"][/video]')) .
                    Html::tag('div', '[team title="They will cook for you" subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." team_ids="1,2,3,4" limit="3" button_label="View Shop" button_icon="general/menu.png" button_url="/shop-2"][/team]') .
                    Html::tag('div', '[testimonials title="Reviews about us" description="Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." limit="5" button_url="#" button_label="All reviews" button_icon="general/dialog.png"][/testimonials]') .
                    Html::tag('div', '[apps-download title="Download our mobile app." subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." image="backgrounds/phones.png" platform_button_image_1="platforms/android.png" platform_url_1="#" platform_button_image_2="platforms/ios.png" platform_url_2="#"][/apps-download]')
                ,
                'metabox' => [
                    'breadcrumb_style' => 'expanded',
                ],
            ],
            [
                'name' => 'Blog style 1',
                'slug' => 'blog',
                'content' =>
                    Html::tag('div', '[blog-posts style="2" title="Latest publications" description="Below is the latest news from us. We get regularly updated from reliable sources."][/blog-posts]') .
                    Html::tag('div', '[blog-footer widget="blog-footer"][/blog-footer]')
                ,
            ],
            [
                'name' => 'Blog style 2',
                'slug' => 'blog-2',
                'content' =>
                    Html::tag('div', '[blog-posts style="3" title="Latest publications" description="Below is the latest news from us. We get regularly updated from reliable sources."][/blog-posts]') .
                    Html::tag('div', '[blog-footer widget="blog-footer"][/blog-footer]')
                ,
            ],
            [
                'name' => 'Gallery 1',
                'content' => Html::tag('div', '[galleries-list per_page="8" style="1"][/galleries-list]'),
            ],
            [
                'name' => 'Gallery 2',
                'content' => Html::tag('div', '[galleries-list per_page="8" style="2"][/galleries-list]'),
            ],
            [
                'name' => 'Reviews',
                'slug' => 'reviews',
                'content' =>
                    Html::tag('div', '[testimonials-list][/testimonials-list]') .
                    Html::tag('div', '[apps-download title="Download our mobile app." subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." image="backgrounds/phones.png" platform_button_image_1="platforms/android.png" platform_url_1="#" platform_button_image_2="platforms/ios.png" platform_url_2="#"][/apps-download]')
                ,
            ],
            [
                'name' => 'FAQs',
                'content' =>
                    Html::tag('div', '[faqs categories="1,2,3,4"][/faqs]') .
                    Html::tag('div', '[apps-download title="Download our mobile app." subtitle="Consecrate numeral port nemo venial diligent rem disciple quo mod." image="backgrounds/phones.png" platform_button_image_1="platforms/android.png" platform_url_1="#" platform_button_image_2="platforms/ios.png" platform_url_2="#"][/apps-download]'),
            ],
            [
                'name' => 'Shop list 1',
                'content' =>
                    Html::tag('div', '[products-list type="all" style="static" items_per_row="4" per_page="16" footer_style="rating"][/products-list]') .
                    Html::tag('div', '[promo title_left="-50%" subtitle_left="Discount for all* burgers!" description_left="*Et modi itaque praesentium." image_left="illustrations/burger.png" button_label_left="Get it now" button_url_left="/products" title_right="Visit Starbelly and get your coffee*" subtitle_right="For free!" description_right="*Et modi itaque praesentium." image_right="illustrations/cup.png" button_label_right="Get it now" button_url_right="#"][/promo]')
                ,
            ],
            [
                'name' => 'Shop list 2',
                'content' =>
                    Html::tag('div', '[products-list type="all" style="static" items_per_row="3" per_page="15" footer_style="add-to-cart"][/products-list]') .
                    Html::tag('div', '[call-to-action title="-50% Discount for all* burgers!" description="*Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." image="illustrations/burger-2.png" style_image="product" button_primary_url="#" button_primary_label="Get it now!" button_primary_icon="general/cart.png" button_secondary_url="#" button_secondary_label="Menu" button_secondary_icon="general/menu.png"][/call-to-action]')
                ,
            ],
            [
                'name' => 'Contact',
                'content' =>
                    Html::tag('div', '[contact-form title="Get in Touch with Starbelly" subtitle="Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi." image_primary="illustrations/envelope-1.png" image_secondary="illustrations/envelope-2.png"][/contact-form]') .
                    Html::tag('div', '[contact-information title_1="Welcome" description_1="Montréal, 1510 Rue Sauvé" title_2="Call" description_2="+02 (044) 756-X6-52" title_3="Write" description_3="starbelly@mail.com"][/contact-information]') .
                    Html::tag('div', '[google-map]Montréal, 1510 Rue Sauvé[/google-map]'),
                'template' => 'homepage',
            ],
        ];

        foreach ($pages as $item) {
            $page = Page::query()->create([
                'user_id' => 1,
                'name' => Arr::get($item, 'name'),
                'description' => Arr::get($item, 'description'),
                'content' => Arr::get($item, 'content'),
                'template' => Arr::get($item, 'template', 'default'),
            ]);

            Slug::query()->create([
                'reference_type' => Page::class,
                'reference_id' => $page->id,
                'key' => Arr::get($item, 'slug', Str::slug($page->name)),
                'prefix' => SlugHelper::getPrefix(Page::class),
            ]);

            foreach (Arr::get($item, 'metabox', []) as $key => $value) {
                MetaBox::saveMetaBoxData($page, $key, $value);
            }
        }

        $translations = [];

        foreach ($translations as $index => $item) {
            DB::table('pages_translations')->insert([
                'lang_code' => 'vi',
                'pages_id' => $index,
                'name' => $item['name'],
                'content' => $item['content'],
            ]);
        }
    }
}
