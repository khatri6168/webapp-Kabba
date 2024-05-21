<div class="sb-p-90-60">
    <div class="container">
        @if ($description = $gallery->description)
            <div class="sb-mb-60">
                <p class="sb-text">{!! BaseHelper::clean($description) !!}</p>
            </div>
        @endif
        @switch(request()->input('gallery_page_detail_style') ?? theme_option('gallery_page_detail_style'))
            @case(2)
                <div class="sb-masonry-grid">
                    <div class="sb-grid-sizer"></div>
                    @foreach(gallery_meta_data($gallery) as $image)
                        <div class="sb-grid-item sb-item-50">
                            <div @class(['sb-gallery-item sb-mb-30', 'sb-gallery-vert' => $loop->even])>
                                <img src="{{ RvMedia::getImageUrl($image['img']) }}" alt="photo">
                                <a data-fancybox="gallery" data-no-swup="" href="{{ RvMedia::getImageUrl($image['img']) }}" class="sb-btn sb-btn-2 sb-btn-icon sb-btn-gray sb-zoom">
                          <span class="sb-icon">
                            <img src="{{ Theme::asset()->url('images/icons/zoom.svg') }}" alt="{{ __('View') }}">
                          </span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                @break
            @default
                <div class="sb-masonry-grid">
                    <div class="sb-grid-sizer"></div>
                    @foreach(gallery_meta_data($gallery) as $image)
                        <div class="sb-grid-item sb-item-33">
                            <div @class(['sb-gallery-item sb-mb-30', 'sb-gallery-vert' => $loop->even])>
                                <img src="{{ RvMedia::getImageUrl($image['img']) }}" alt="photo">
                                <a data-fancybox="gallery" data-no-swup href="{{ RvMedia::getImageUrl($image['img']) }}" class="sb-btn sb-btn-2 sb-btn-icon sb-btn-gray sb-zoom">
                      <span class="sb-icon">
                        <img src="{{ Theme::asset()->url('images/icons/zoom.svg') }}" alt="{{ __('View') }}">
                      </span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
        @endswitch
    </div>

    <section class="sb-call-to-action">
        {!! dynamic_sidebar('galleries_sidebar') !!}
    </section>
</div>
