@foreach($galleries as $gallery)
    <div @class(['sb-grid-item', 'sb-item-33' => $style == 1, 'sb-item-50' => $style == 2  ])>
        <a href="{{ $gallery->url }}" class="sb-blog-card sb-mb-30">
            <div @class(['sb-cover-frame sb-mb-30', 'sb-cover-vert' => $loop->even])>
                <img src="{{ RvMedia::getImageUrl($gallery->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $gallery->name }}">
                @if ($gallery->is_featured)
                    <div class="sb-badge">{{ __('Popular') }}</div>
                @endif
            </div>
            <div class="sb-blog-card-descr">
                <h3 class="sb-mb-10">{!! BaseHelper::clean($gallery->name) !!}</h3>
                <p class="sb-text">{!! BaseHelper::clean($gallery->description) !!}</p>
            </div>
        </a>
    </div>
@endforeach
