@php
    Theme::set('breadcrumbStyle', $page->getMetaData('breadcrumb_style', true));
    Theme::set('pageDescription', $page->description);
    Theme::set('breadcrumbImage', $page->getMetaData('background_breadcrumb', true) ?: theme_option('background_breadcrumb_default'));
@endphp

{!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, Html::tag('div', BaseHelper::clean($page->content), ['class' => 'ck-content'])->toHtml(), 
$page) !!}
