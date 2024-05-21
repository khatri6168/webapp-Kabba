@if (is_plugin_active('blog'))
    @php
        $limit = (int) Arr::get($config, 'limit', 10);
        $type = Arr::get($config, 'type');

        if ($limit > 0) {
            $tags = get_popular_tags($limit);
        } else {
            $tags = get_all_tags();
        }
    @endphp

    @if ($tags->count())
        <div class="sb-ib-title-frame sb-mb-30">
            <h4>{!! BaseHelper::clean(Arr::get($config, 'name')) !!}</h4>
            <i class="fas fa-arrow-down"></i>
        </div>
        <ul class="sb-keywords">
            @foreach($tags as $tag)
                <li>
                    <a href="{{ $tag->url }}">{!! BaseHelper::clean($tag->name) !!}</a>
                </li>
            @endforeach
        </ul>
    @endif
@endif
