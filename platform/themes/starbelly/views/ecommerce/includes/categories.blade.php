@php
    $categories->loadMissing(['slugable', 'activeChildren:id,name,parent_id', 'activeChildren.slugable']);

    if (! empty($categoriesRequest)) {
        $categories = $categories->whereIn('id', $categoriesRequest);
    }
@endphp

<ul>
    @if (! empty($categoriesRequest))
        <li class="category-filter mb-3">
            <a class="nav-list__item-link" href="{{ route('public.products') }}" data-id="">
                <i class="fas fa-chevron-left toggle-menu"></i>
                <span>{{ __('All categories') }}</span>
            </a>
        </li>
    @endif

    @foreach($categories as $category)
        @php
            $isActive = url()->current() === $category->url
                || (! empty($categoriesRequest && in_array($category->id, $categoriesRequest)))
                || ($loop->first && $categoriesRequest && $categories->count() === 1 && $category->activeChildren->count());
        @endphp
        <li @class(['category-filter', 'opened' => $isActive])>
            <div class="widget-layered-nav-list__item">
                <div class="nav-list__item-title">
                    <a @class(['nav-list__item-link', 'active' => $isActive]) href="{{ $category->url }}" data-id="{{ $category->id }}">
                        @if (! $category->parent_id)
                            @if ($category->getMetaData('icon_image', true))
                                <img src="{{ RvMedia::getImageUrl($category->getMetaData('icon_image', true)) }}" alt="{{ $category->name }}" width="18" height="18">
                            @elseif ($category->getMetaData('icon', true))
                                <i class="{{ $category->getMetaData('icon', true) }}"></i>
                            @endif
                            <span class="ms-1">{!! BaseHelper::clean($category->name) !!}</span>
                        @else
                            <span>{!! BaseHelper::clean($category->name) !!}</span>
                        @endif
                    </a>
                </div>
                @if ($category->activeChildren->count())
                    <i @class(['toggle-menu fas', 'fa-plus' => ! $isActive, 'fa-minus' => $isActive])></i>
                @endif
            </div>
            @if ($category->activeChildren->count())
                @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.categories', [
                    'categories' => $category->activeChildren,
                    'categoriesRequest' => [],
                ])
            @endif
        </li>
    @endforeach
</ul>
