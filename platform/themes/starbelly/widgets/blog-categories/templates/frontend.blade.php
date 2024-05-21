@if (is_plugin_active('blog'))
    @php
        $limit = (int) Arr::get($config, 'limit', 10);
        $type = Arr::get($config, 'type');

        if ($limit > 0) {
            $categories = get_popular_categories($limit);
        } else {
            $categories = get_all_categories();
        }
    @endphp

    @if ($categories->count())
        <div class="sb-ib-title-frame sb-mb-30">
            <h4>{!! BaseHelper::clean(Arr::get($config, 'name')) !!}</h4>
            <i class="fas fa-arrow-down"></i>
        </div>
        <ul class="sb-list sb-mb-30">
            @foreach($categories as $category)
                <li>
                    <b><a href="{{ $category->url }}">{!! BaseHelper::clean($category->name) !!}</a></b>
                    <span class="sb-number">{{ number_format($category->posts_count) }}</span>
                </li>
            @endforeach
        </ul>
    @endif
@endif
