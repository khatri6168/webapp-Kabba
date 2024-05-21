<?php

use Carbon\Carbon;

app()->booted(function () {
    theme_option()
        ->setSection([
            'title' => __('Social Links'),
            'desc' => __('Social Links at the footer.'),
            'id' => 'opt-text-subsection-social-links',
            'subsection' => true,
            'icon' => 'fas fa-icons',
            'fields' => [
                [
                    'id' => 'social_links',
                    'type' => 'repeater',
                    'label' => __('Social Links'),
                    'attributes' => [
                        'name' => 'social_links',
                        'value' => null,
                        'fields' => [
                            [
                                'type' => 'text',
                                'label' => __('Name'),
                                'attributes' => [
                                    'name' => 'social-name',
                                    'value' => null,
                                    'options' => [
                                        'class' => 'form-control',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'themeIcon',
                                'label' => __('Icon'),
                                'attributes' => [
                                    'name' => 'social-icon',
                                    'value' => null,
                                    'options' => [
                                        'class' => 'form-control',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'text',
                                'label' => __('URL'),
                                'attributes' => [
                                    'name' => 'social-url',
                                    'value' => null,
                                    'options' => [
                                        'class' => 'form-control',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])
        ->setField([
            'id' => 'copyright',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'text',
            'label' => __('Copyright'),
            'attributes' => [
                'name' => 'copyright',
                'value' => __('© :year Your Company. All right reserved.', ['year' => Carbon::now()->format('Y')]),
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => __('Change copyright'),
                    'data-counter' => 250,
                ],
            ],
            'helper' => __('Copyright on footer of site'),
        ])
        ->setField([
            'id' => 'primary_font',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'googleFonts',
            'label' => __('Primary font'),
            'attributes' => [
                'name' => 'primary_font',
                'value' => 'Roboto',
            ],
        ])
        ->setField([
            'id' => 'secondary_font',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'googleFonts',
            'label' => __('Secondary font'),
            'attributes' => [
                'name' => 'secondary_font',
                'value' => 'Monoton',
            ],
        ])
        ->setField([
            'id' => 'primary_color',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => __('Primary color'),
            'attributes' => [
                'name' => 'primary_color',
                'value' => '#ff2b4a',
            ],
        ])
        ->setField([
            'id' => 'top_bar_color',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => __('Top bar color'),
            'attributes' => [
                'name' => 'top_bar_color',
                'value' => '#ff2b4a',
            ],
        ])
        ->setField([
            'id' => 'blog_default_breadcrumb_style',
            'section_id' => 'opt-text-subsection-blog',
            'type' => 'customSelect',
            'label' => __('Breadcrumb style'),
            'attributes' => [
                'name' => 'blog_default_breadcrumb_style',
                'list' => [
                    'compact' => __('Compact'),
                    'expanded' => __('Expanded'),
                ],
                'value' => 'compact',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'blog_post_detail_style',
            'section_id' => 'opt-text-subsection-blog',
            'type' => 'customSelect',
            'label' => __(' Post detail style'),
            'attributes' => [
                'name' => 'blog_post_detail_style',
                'list' => [
                    'with-sidebar' => __('With sidebar'),
                    'without-sidebar' => __('Without sidebar'),
                ],
                'value' => 'with-sidebar',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setSection([
            'title' => __('Galleries'),
            'id' => 'opt-text-subsection-gallery',
            'subsection' => true,
            'icon' => 'fas fa-icons',
            'fields' => [
                [
                    'id' => 'page_title',
                    'type' => 'text',
                    'label' => __('Page title'),
                    'attributes' => [
                        'name' => 'gallery_page_title',
                        'value' => null,
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => __('Page title'),
                            'data-counter' => 250,
                        ],
                    ],
                ],
                [
                    'id' => 'page_description',
                    'type' => 'text',
                    'label' => __('Page description'),
                    'attributes' => [
                        'name' => 'gallery_page_description',
                        'value' => null,
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => __('Page description'),
                            'data-counter' => 250,
                        ],
                    ],
                ],
                [
                    'id' => 'gallery_breadcrumb_title',
                    'type' => 'text',
                    'label' => __('Breadcrumb title'),
                    'attributes' => [
                        'name' => 'gallery_breadcrumb_title',
                        'value' => null,
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => __('Breadcrumb title'),
                            'data-counter' => 250,
                        ],
                    ],
                ],
                [
                    'id' => 'gallery_breadcrumb_subtitle',
                    'type' => 'text',
                    'label' => __('Breadcrumb subtitle'),
                    'attributes' => [
                        'name' => 'gallery_breadcrumb_subtitle',
                        'value' => null,
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => __('Breadcrumb subtitle'),
                            'data-counter' => 250,
                        ],
                    ],
                ],
                [
                    'id' => 'gallery_page_style',
                    'section_id' => 'opt-text-subsection-page',
                    'type' => 'customSelect',
                    'label' => __('Choose style gallery page'),
                    'attributes' => [
                        'name' => 'gallery_page_style',
                        'list' => [
                            1 => __('Style 1'),
                            2 => __('Style 2'),
                        ],
                        'value' => 1,
                        'options' => [
                            'class' => 'form-control',
                        ],
                    ],
                ],
                [
                    'id' => 'gallery_page_detail_style',
                    'section_id' => 'opt-text-subsection-page',
                    'type' => 'customSelect',
                    'label' => __('Choose style gallery page detail'),
                    'attributes' => [
                        'name' => 'gallery_page_detail_style',
                        'list' => [
                            1 => __('Style 1'),
                            2 => __('Style 2'),
                        ],
                        'value' => 1,
                        'options' => [
                            'class' => 'form-control',
                        ],
                    ],
                ],
            ],
        ])
        ->setField(
            [
                'id' => 'background_image_page_404',
                'section_id' => 'opt-text-subsection-page',
                'type' => 'mediaImage',
                'label' => __('Background image page 404'),
                'attributes' => [
                    'name' => 'background_image_page_404',
                    'value' => '',
                ],
            ],
        )
        ->setField([
            'id' => 'default_products_list_page_style',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type' => 'customSelect',
            'label' => __('Default products list page style'),
            'attributes' => [
                'name' => 'default_products_list_page_style',
                'list' => [
                    1 => __('Three items on per row'),
                    2 => __('Four items on per row'),
                ],
                'value' => 1,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'background_breadcrumb_default',
            'section_id' => 'opt-text-subsection-page',
            'type' => 'mediaImage',
            'label' => __('Background Breadcrumb Default'),
            'attributes' => [
                'name' => 'background_breadcrumb_default',
                'value' => '',
            ],
        ]);
});
