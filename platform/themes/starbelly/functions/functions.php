<?php

use Botble\Base\Facades\Form;
use Botble\Base\Facades\MetaBox;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Forms\FormHelper;
use Botble\Base\Models\BaseModel;
use Botble\Media\Facades\RvMedia;
use Botble\Page\Models\Page;
use Botble\Theme\Facades\Theme;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Theme\Starbelly\Forms\Fields\ThemeIconField;

register_page_template([
    'default' => 'Default',
    'homepage' => 'Homepage',
]);

register_sidebar([
    'id' => 'blog-footer',
    'name' => 'Blog Footer',
    'description' => 'Footer of the blog page.',
]);

register_sidebar([
    'id' => 'blog-sidebar',
    'name' => 'Blog Sidebar',
    'description' => 'Sidebar of the blog page.',
]);

register_sidebar([
    'id' => 'galleries_sidebar',
    'name' => 'Galleries Sidebar',
    'description' => 'Footer galleries page.',
]);

register_sidebar([
    'id' => 'information-sidebar',
    'name' => 'Information sidebar',
    'description' => __('Widgets at the tab header of the page.'),
]);

register_sidebar([
    'id' => 'product-footer',
    'name' => 'Product Footer',
    'description' => __('Footer of the product detail page'),
]);

register_sidebar([
    'id' => 'products-list-footer',
    'name' => 'Product List Footer',
    'description' => __('Footer of the products list page'),
]);

register_sidebar([
    'id' => 'pre_footer_sidebar',
    'name' => 'Pre Footer',
    'description' => __('Widgets at the bottom of the page.'),
]);

RvMedia::setUploadPathAndURLToPublic();

RvMedia::addSize('medium', 800, 800);

add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function (FormAbstract $form, ?BaseModel $data) {
    if (get_class($data) === Page::class) {
        $form
            ->addAfter('template', 'breadcrumb_style', 'customSelect', [
                'label' => __('Breadcrumb style'),
                'label_attr' => ['class' => 'control-label'],
                'choices' => [
                    'compact' => __('compact'),
                    'expanded' => __('Expanded'),
                ],
                'selected' => $data->getMetaData('breadcrumb_style', true),
            ])
            ->add('background_breadcrumb', 'mediaImage', [
                'label' => __('Background Breadcrumb'),
                'label_attr' => ['class' => 'control-label'],
                'value' => MetaBox::getMetaData($data, 'background_breadcrumb', true),
            ]);
    }

    return $form;
}, 120, 3);

add_action(
    [BASE_ACTION_AFTER_CREATE_CONTENT, BASE_ACTION_AFTER_UPDATE_CONTENT],
    function (string $screen, FormRequest|Request $request, BaseModel $data): void {
        if ($data instanceof Page) {
            if ($request->has('breadcrumb_style')) {
                MetaBox::saveMetaBoxData($data, 'breadcrumb_style', $request->input('breadcrumb_style'));
            }

            if ($request->has('background_breadcrumb')) {
                MetaBox::saveMetaBoxData($data, 'background_breadcrumb', $request->input('background_breadcrumb'));
            }
        }
    },
    120,
    3
);

add_filter('form_custom_fields', function (FormAbstract $form, FormHelper $formHelper) {
    if (! $formHelper->hasCustomField('themeIcon')) {
        $form->addCustomField('themeIcon', ThemeIconField::class);
    }

    return $form;
}, 29, 2);

Form::component('themeIcon', Theme::getThemeNamespace('partials.forms.fields.icons-field'), [
    'name',
    'value' => null,
    'attributes' => [],
]);
