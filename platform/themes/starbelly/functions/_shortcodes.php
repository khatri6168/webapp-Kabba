<?php

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Blog\Repositories\Interfaces\PostInterface;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Repositories\Interfaces\FlashSaleInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductCategoryInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Faq\Contracts\Faq;
use Botble\Faq\FaqCollection;
use Botble\Faq\FaqItem;
use Botble\Faq\Repositories\Interfaces\FaqCategoryInterface;
use Botble\Gallery\Repositories\Interfaces\GalleryInterface;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\Team\Repositories\Interfaces\TeamInterface;
use Botble\Testimonial\Repositories\Interfaces\TestimonialInterface;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;

app()->booted(function () {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    add_shortcode('hero-banner', __('Hero Banner'), __('Hero Banner'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.hero-banner.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('hero-banner', function (array $attributes) {
        return Theme::partial('shortcodes.hero-banner.admin', compact('attributes'));
    });

    add_shortcode('our-features', __('Our features'), __('Our features'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.our-features.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('our-features', function (array $attributes) {
        return Theme::partial('shortcodes.our-features.admin', compact('attributes'));
    });

    if (is_plugin_active('ecommerce')) {
        add_shortcode('products-list', __('Popular products'), __('Popular products'), function (Shortcode $shortcode) {
            Theme::asset()->container('footer')->usePath()->add('swiper', 'plugins/swiper.min.js');
            Theme::asset()->usePath()->add('swiper-css', 'plugins/swiper.min.css');

            $perPage = (int)$shortcode->per_page ?: 12;

            $reviewsRelation = EcommerceHelper::withReviewsParams();

            $products = match ($shortcode->type) {
                'trending' => get_trending_products(
                    array_merge([
                        'paginate' => [
                            'per_page' => $perPage,
                            'current_paged' => (int)request()->input('page'),
                        ],
                        'take' => null,
                    ], $reviewsRelation)
                ),
                'featured' => get_featured_products(
                    array_merge([
                        'paginate' => [
                            'per_page' => $perPage,
                            'current_paged' => (int)request()->input('page'),
                        ],
                    ], $reviewsRelation)
                ),
                default => app(ProductInterface::class)->advancedGet(
                    array_merge([
                        'condition' => [
                            'ec_products.status' => BaseStatusEnum::PUBLISHED,
                        ],
                        'paginate' => [
                            'per_page' => $perPage,
                            'current_paged' => (int)request()->input('page'),
                        ],
                    ], $reviewsRelation)
                ),
            };

            return Theme::partial('shortcodes.products-list.index', compact('shortcode', 'products'));
        });

        shortcode()->setAdminConfig('products-list', function (array $attributes) {
            return Theme::partial('shortcodes.products-list.admin', compact('attributes'));
        });

        add_shortcode(
            'featured-categories',
            __('Category feature'),
            __('Category feature'),
            function (Shortcode $shortcode) {
                if (! $shortcode->category_ids) {
                    return null;
                }

                $categories = app(ProductCategoryInterface::class)->advancedGet([
                    'condition' => [
                        'IN' => ['id', 'IN', explode(',', $shortcode->category_ids)],
                    ],
                ]);

                return Theme::partial('shortcodes.featured-categories.index', compact('shortcode', 'categories'));
            }
        );

        shortcode()->setAdminConfig('featured-categories', function (array $attributes) {
            $categories = app(ProductCategoryInterface::class)->advancedGet([
                'condition' => ['status' => BaseStatusEnum::PUBLISHED],
                'order_by' => ['created_at' => 'DESC'],
            ]);

            return Theme::partial('shortcodes.featured-categories.admin', compact('attributes', 'categories'));
        });

        add_shortcode(
            'flash-sale-popup',
            __('Flash sale popup'),
            __('Flash sale popup'),
            function (Shortcode $shortcode) {
                if (! $shortcode->flash_sale_ids) {
                    return null;
                }

                $flashSaleId = explode(',', $shortcode->flash_sale_ids);

                $randomFlashSaleId = $flashSaleId[rand(0, count($flashSaleId) - 1)];

                $flashSale = app(FlashSaleInterface::class)->findById($randomFlashSaleId);

                if (! $flashSale && $flashSale->products->count()) {
                    return null;
                }

                $product = $flashSale->products->random();

                return Theme::partial(
                    'shortcodes.flash-sale-popup.index',
                    compact('shortcode', 'product', 'flashSale')
                );
            }
        );

        shortcode()->setAdminConfig('flash-sale-popup', function (array $attributes) {
            $flashSales = app(FlashSaleInterface::class)->getAvailableFlashSales();

            return Theme::partial('shortcodes.flash-sale-popup.admin', compact('attributes', 'flashSales'));
        });
    }

    if (is_plugin_active('team')) {
        add_shortcode('team', __('Team'), __('Team'), function (Shortcode $shortcode) {
            if (! $shortcode->team_ids) {
                return null;
            }

            $shortcode->limit = (int)$shortcode->limit ?: 4;

            $teams = app(TeamInterface::class)->advancedGet([
                'condition' => [
                    'IN' => ['id', 'IN', explode(',', $shortcode->team_ids)],
                ],
                'take' => $shortcode->limit,
            ]);

            return Theme::partial('shortcodes.team.index', compact('shortcode', 'teams'));
        });

        shortcode()->setAdminConfig('team', function (array $attributes) {
            $teams = app(TeamInterface::class)->advancedGet([
                'condition' => ['status' => BaseStatusEnum::PUBLISHED],
                'order_by' => ['created_at' => 'DESC'],
            ]);

            return Theme::partial('shortcodes.team.admin', compact('attributes', 'teams'));
        });
    }

    add_shortcode('apps-download', __('Apps download'), __('Apps download'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.apps-download.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('apps-download', function (array $attributes) {
        return Theme::partial('shortcodes.apps-download.admin', compact('attributes'));
    });

    if (is_plugin_active('blog')) {
        add_shortcode('blog-posts', __('Blog Posts'), __('Blog Posts'), function (Shortcode $shortcode) {
            $posts = app(PostInterface::class)->getModel()->paginate();

            return Theme::partial('shortcodes.blog-posts.index', compact('shortcode', 'posts'));
        });

        shortcode()->setAdminConfig('blog-posts', function (array $attributes) {
            return Theme::partial('shortcodes.blog-posts.admin', compact('attributes'));
        });

        add_shortcode('blog-footer', __('Blog Footer'), __('Blog Footer'), function (Shortcode $shortcode) {
            return Theme::partial('shortcodes.blog-footer.index', compact('shortcode'));
        });

        shortcode()->setAdminConfig('blog-footer', function (array $attributes) {
            return Theme::partial('shortcodes.blog-footer.admin', compact('attributes'));
        });
    }

    add_shortcode('about-text', __('About Text'), __('About Text'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.about-text.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('about-text', function (array $attributes) {
        return Theme::partial('shortcodes.about-text.admin', compact('attributes'));
    });

    add_shortcode('features', __('Features'), __('Features'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.features.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('features', function (array $attributes) {
        return Theme::partial('shortcodes.features.admin', compact('attributes'));
    });

    add_shortcode('video', __('Video'), __('Video'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.video.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('video', function (array $attributes) {
        return Theme::partial('shortcodes.video.admin', compact('attributes'));
    });

    if (is_plugin_active('testimonial')) {
        add_shortcode('testimonials', __('Testimonials'), __('Testimonials'), function (Shortcode $shortcode) {
            Theme::asset()->container('footer')->usePath()->add('swiper', 'plugins/swiper.min.js');
            Theme::asset()->usePath()->add('swiper-css', 'plugins/swiper.min.css');

            $testimonials = app(TestimonialInterface::class)->advancedGet([
                'condition' => ['status' => BaseStatusEnum::PUBLISHED],
                'take' => (int)$shortcode->limit ?: 5,
            ]);

            return Theme::partial('shortcodes.testimonials.index', compact('shortcode', 'testimonials'));
        });

        shortcode()->setAdminConfig('testimonials', function (array $attributes) {
            return Theme::partial('shortcodes.testimonials.admin', compact('attributes'));
        });

        add_shortcode(
            'testimonials-list',
            __('Testimonials list'),
            __('Testimonials list'),
            function (Shortcode $shortcode) {
                $testimonials = app(TestimonialInterface::class)->advancedGet([
                    'condition' => ['status' => BaseStatusEnum::PUBLISHED],
                    'paginate' => [
                        'per_page' => (int)$shortcode->per_page ?: 8,
                        'current_paged' => (int)request()->input('page') ?: 1,
                    ],

                ]);

                return Theme::partial('shortcodes.testimonials-list.index', compact('shortcode', 'testimonials'));
            }
        );

        shortcode()->setAdminConfig('testimonials-list', function (array $attributes) {
            return Theme::partial('shortcodes.testimonials-list.admin', compact('attributes'));
        });
    }

    add_shortcode('call-to-action', __('Call To Action'), __('Call To Action'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.call-to-action.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('call-to-action', function (array $attributes) {
        return Theme::partial('shortcodes.call-to-action.admin', compact('attributes'));
    });

    add_shortcode('promo', __('Promo'), __('Promo'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.promo.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('promo', function (array $attributes) {
        return Theme::partial('shortcodes.promo.admin', compact('attributes'));
    });
    if(is_plugin_active('terms')){
        add_shortcode('customer_initials',__('Customer Initials'),__('Customer Initials'),function (Shortcode $shortcode){
            return Theme::partial('shortcodes.terms.index', compact('shortcode'));
        });
        add_shortcode('product_terms',__('Product Terms'),__('Product Terms'),function (Shortcode $shortcode){
            return Theme::partial('shortcodes.terms.index', compact('shortcode'));
        });
    }
    if (is_plugin_active('faq')) {
        add_shortcode('faqs', __('FAQ'), __('FAQ'), function (Shortcode $shortcode) {
            if (! $shortcode->categories) {
                return null;
            }

            $condition = ['status' => BaseStatusEnum::PUBLISHED];

            if ($shortcode->categories) {
                $categoryIds = explode(',', $shortcode->categories);

                if ($categoryIds) {
                    $condition[] = ['id', 'IN', $categoryIds];
                }
            }

            $categories = app(FaqCategoryInterface::class)->advancedGet([
                'with' => ['faqs'],
                'condition' => $condition,
            ]);

            if (setting('enable_faq_schema', 0)) {
                $schemaItems = new FaqCollection();

                foreach ($categories as $category) {
                    foreach ($category->faqs as $faq) {
                        $schemaItems->push(new FaqItem($faq->question, $faq->answer));
                    }
                }

                app(Faq::class)->registerSchema($schemaItems);
            }

            return Theme::partial('shortcodes.faqs.index', compact('shortcode', 'categories'));
        });

        shortcode()->setAdminConfig('faqs', function (array $attributes) {
            $categories = app(FaqCategoryInterface::class)->advancedGet([
                'with' => ['faqs'],
                'condition' => ['status' => BaseStatusEnum::PUBLISHED],
            ]);

            return Theme::partial('shortcodes.faqs.admin', compact('attributes', 'categories'));
        });
    }

    if (is_plugin_active('gallery')) {
        add_shortcode('galleries-list', __('Galleries list'), __('Galleries list'), function (Shortcode $shortcode) {
            Theme::asset()->usePath()->add('fancybox', 'plugins/fancybox.min.css');
            $galleries = app(GalleryInterface::class)->advancedGet([
                'paginate' => [
                    'per_page' => (int)$shortcode->per_page ?: 8,
                    'current_paged' => (int)request()->input('page') ?: 1,
                ],
            ]);

            return Theme::partial('shortcodes.galleries-list.index', compact('shortcode', 'galleries'));
        });

        shortcode()->setAdminConfig('galleries-list', function (array $attributes) {
            return Theme::partial('shortcodes.galleries-list.admin', compact('attributes'));
        });
    }

    if (is_plugin_active('contact')) {
        add_filter(CONTACT_FORM_TEMPLATE_VIEW, function () {
            return Theme::getThemeNamespace() . '::partials.shortcodes.contact-form.index';
        }, 120);

        shortcode()->setAdminConfig('contact-form', function (array $attributes) {
            return Theme::partial('shortcodes.contact-form.admin', compact('attributes'));
        });
    }

    add_shortcode(
        'contact-information',
        __('Contact information'),
        __('Contact information'),
        function (Shortcode $shortcode) {
            return Theme::partial('shortcodes.contact-information.index', compact('shortcode'));
        }
    );

    shortcode()->setAdminConfig('contact-information', function (array $attributes) {
        return Theme::partial('shortcodes.contact-information.admin', compact('attributes'));
    });
});
