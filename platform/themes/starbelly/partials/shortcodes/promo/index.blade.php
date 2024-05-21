<section class="sb-p-0-60">
    <div class="container">
        <div class="row">
            @foreach(['left', 'right'] as $col)
                <div class="col-lg-6">
                    <div class="sb-promo-frame sb-mb-30">
                        <div class="sb-promo-content">
                            <div class="sb-text-frame">
                                @if($title = $shortcode->{'title_' . $col})
                                    @if($col === 'left')
                                        <h3 class="sb-mb-10">
                                            <b class="sb-h2">{!! BaseHelper::clean($title) !!}</b>
                                        </h3>
                                    @else
                                        <h3 class="sb-mb-15">{!! BaseHelper::clean($title) !!}</h3>
                                    @endif
                                @endif

                                @if($subtitle = $shortcode->{'subtitle_' . $col})
                                    @if($col === 'left')
                                        <h3 class="sb-mb-15">{!! BaseHelper::clean($subtitle) !!}</h3>
                                    @else
                                        <h3 class="sb-mb-10"><b class="sb-h2">{!! BaseHelper::clean($subtitle) !!}</b></h3>
                                    @endif
                                @endif

                                @if($description = $shortcode->{'description_' . $col})
                                    <p class="sb-text sb-text-sm sb-mb-15">{!! BaseHelper::clean($description) !!}</p>
                                @endif

                                @if($buttonLabel = $shortcode->{'button_label_' . $col})
                                    <a href="{{ $shortcode->{'button_url_' . $col} }}" class="sb-btn sb-ppc">
                                        <span class="sb-icon">
                                            <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="{{ $buttonLabel }}">
                                        </span>
                                        <span>{!! BaseHelper::clean($buttonLabel) !!}</span>
                                    </a>
                                @endif
                            </div>
                            <div class="sb-image-frame">
                                <div class="sb-illustration-{{ $col === 'left' ? 4 : 5 }}">
                                    @if($image = $shortcode->{'image_' . $col})
                                        <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $title }}" class="sb-{{ $col === 'left' ? 'burger' : 'cup' }}">
                                    @endif
                                    <div class="sb-cirkle-1"></div>
                                    <div class="sb-cirkle-2"></div>
                                    <div class="sb-cirkle-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
