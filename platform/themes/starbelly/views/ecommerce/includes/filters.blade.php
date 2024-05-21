@php
    $brands = get_all_brands(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], [], ['products']);

    $tags = app(\Botble\Ecommerce\Repositories\Interfaces\ProductTagInterface::class)->advancedGet([
        'condition' => ['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED],
        'with' => [],
        'withCount' => ['products'],
        'order_by' => ['products_count' => 'desc'],
        'take' => 10,
    ]);

    $categoriesRequest = request()->query('categories', []);

    Theme::asset()->usePath()->add('nouislider-css', 'plugins/nouislider/nouislider.min.css');
    Theme::asset()->container('footer')->usePath() ->add('nouislider-js', 'plugins/nouislider/nouislider.min.js');
    Theme::asset()->usePath()->add('custom-scrollbar-css', 'plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.css');
    Theme::asset()->container('footer')->usePath() ->add('custom-scrollbar-js', 'plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js');
@endphp

<aside class="catalog-primary-sidebar catalog-sidebar" data-toggle-target="product-categories-primary-sidebar">
    <div class="backdrop"></div>
    <div class="catalog-sidebar--inner side-left">
        <div class="d-flex justify-content-between align-items-center px-3 my-4 d-md-none">
            <button type="button" class="btn btn-link text-secondary close-toggle--sidebar" data-toggle-closest=".catalog-primary-sidebar">
                <i class="fas fa-chevron-left"></i>
            </button>
            <span class="fw-bold">{{ __('Filter Products') }}</span>
        </div>


        <div class="catalog-filter-sidebar-content px-3 px-md-0">
            <form action="{{ url()->current() }}" data-action="{{ route('public.products') }}" method="get" id="products-filter-form">
                <input type="hidden" name="sort-by" value="{{ BaseHelper::stringify(request()->input('sort-by')) }}">
                <input type="hidden" name="layout" value="{{ BaseHelper::stringify(request()->input('layout')) }}">
                <input type="hidden" name="q" value="{{ BaseHelper::stringify(request()->query('q')) }}">

                <div class="widget-wrapper widget-product-categories">
                    <h4 class="widget-title">{{ __('Product Categories') }}</h4>
                    <div class="widget-layered-nav-list">
                        @include(Theme::getThemeNamespace('views.ecommerce.includes.categories'), compact('categories', 'categoriesRequest'))
                    </div>
                </div>

                @if (count($brands) > 0)
                    <div class="widget-wrapper widget-product-brands">
                        <h4 class="widget-title">{{ __('Brands') }}</h4>
                        <div class="widget-layered-nav-list ps-custom-scrollbar">
                            <ul>
                                @foreach($brands as $brand)
                                    @if ($brand->products_count > 0)
                                        <li>
                                            <div class="widget-layered-nav-list__item">
                                                <div class="form-check">
                                                    <input class="form-check-input product-filter-item" type="checkbox" name="brands[]" value="{{ $brand->id }}" id="attribute-brand-{{ $brand->id }}" @if (in_array($brand->id, request()->input('brands', []))) checked @endif>
                                                    <label class="form-check-label" for="attribute-brand-{{ $brand->id }}">
                                                        <span>{{ $brand->name }}</span>
                                                        <span class="count">({{ $brand->products_count }})</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (count($tags) > 0)
                    <div class="widget-wrapper widget-product-tags">
                        <h4 class="widget-title">{{ __('Tags') }}</h4>
                        <div class="widget-layered-nav-list ps-custom-scrollbar">
                            <ul>
                                @foreach($tags as $tag)
                                    @if ($tag->products_count > 0)
                                        <li>
                                            <div class="widget-layered-nav-list__item">
                                                <div class="form-check">
                                                    <input class="form-check-input product-filter-item" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="attribute-tag-{{ $tag->id }}" @if (in_array($tag->id, request()->input('tags', []))) checked @endif>
                                                    <label class="form-check-label" for="attribute-tag-{{ $tag->id }}">
                                                        <span>{{ $tag->name }}</span><span class="count">({{ $tag->products_count }})</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="widget-wrapper">
                    <h4 class="widget-title">{{ __('By Price') }}</h4>
                    <div class="widget__content nonlinear-wrapper">
                        <div class="nonlinear" data-min="0" data-max="{{ (int)theme_option('max_filter_price', 10000) * get_current_exchange_rate() }}"></div>
                        <div class="slider__meta">
                            <input class="product-filter-item product-filter-item-price-0" name="min_price" data-min="0" value="{{ BaseHelper::stringify(request()->input('min_price', 0)) }}" type="hidden">
                            <input class="product-filter-item product-filter-item-price-1" name="max_price" data-max="{{ BaseHelper::stringify(theme_option('max_filter_price', 10000)) }}" value="{{ BaseHelper::stringify(request()->input('max_price', theme_option('max_filter_price', 10000))) }}" type="hidden">
                            <span class="slider__value">
                                <span class="slider__min"></span>
                                {{ get_application_currency()->title }}</span>
                                        -<span class="slider__value">
                                <span class="slider__max"></span>
                                {{ get_application_currency()->title }}
                            </span>
                        </div>
                    </div>
                    {!! render_product_swatches_filter([
                        'view' => Theme::getThemeNamespace('views.ecommerce.attributes.attributes-filter-renderer')
                    ]) !!}
                </div>
            </form>
        </div>
    </div>
</aside>
