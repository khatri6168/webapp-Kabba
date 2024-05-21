@php
    $products->loadMissing('defaultVariation');

    $categories = ProductCategoryHelper::getActiveTreeCategories();

    Theme::set('breadcrumbImage', theme_option('background_breadcrumb_default'));
@endphp

<section class="sb-menu-section sb-p-90-60">
    <div class="sb-bg-1">
        <div></div>
    </div>
    <div class="container sb-mb-90">
        <div class="d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center mb-4">
            <div class="product-found-text sb-text">
                {{-- {{ __(':count Product(s) found', ['count' => $products->count()]) }} --}}
            </div>
            <div class="d-flex align-items-center">
                <div class="d-block d-md-none">
                    <button class="text-primary text-decoration-none btn btn-link sidebar-filter-mobile">
                        <i class="fas fa-filter"></i>
                        {{ __('Filters') }}
                    </button>
                </div>
                @include(Theme::getThemeNamespace('views.ecommerce.includes.sort'))
            </div>
        </div>
        <div class="row">
            <div class="col-md-3" style="display: none;">
                @include(Theme::getThemeNamespace('views.ecommerce.includes.filters'))
            </div>
            <div class="col-md-12 products-listing position-relative">
                @include(Theme::getThemeNamespace('views.ecommerce.includes.product-items'))
            </div>
        </div>
    </div>
</section>

{!! dynamic_sidebar('products-list-footer') !!}
