@if (is_plugin_active('gallery'))
    <div>
        <div class="sb-ib-title-frame sb-mb-30">
            <h4>{{ $config['title_gallery'] }}</h4>
            <i class="fas fa-arrow-down"></i>
        </div>
        <div>
            <ul class="sb-instagram sb-mb-30">
                @foreach(get_galleries((int) $config['number_image']) as $gallery)
                    <li><a href="{{ $gallery->url }}"><img src="{{ Rvmedia::getImageUrl($gallery->image, 'thumb', false, RvMedia::getDefaultImage()) }}"></a></li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
