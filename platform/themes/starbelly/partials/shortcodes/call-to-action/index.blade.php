@php
    if ($shortcode->style_image === 'product') {
        $illustrationStyle = 6;
        $styleImage = $shortcode->style_image;
    } else {
        $illustrationStyle = 8;
        $styleImage = 'service';
    }
@endphp

<section class="sb-call-to-action">
    <div class="sb-bg-3"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="sb-cta-text">
                    <h2 class="sb-h1 sb-mb-15">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                    <p class="sb-text sb-mb-30">{!! BaseHelper::clean($shortcode->description) !!}</p>
                    @if($shortcode->button_primary_label || $shortcode->button_primary_icon)
                        <a href="{{ $shortcode->button_primary_url }}" class="sb-btn">
                        <span class="sb-icon">
                            <img src="{{ RvMedia::getImageUrl($shortcode->button_primary_icon) }}" alt="{{ $shortcode->button_primary_label }}">
                        </span>
                            <span>{!! BaseHelper::clean($shortcode->button_primary_label) !!}</span>
                        </a>
                    @endif
                    @if($shortcode->button_secondary_label || $shortcode->button_secondary_icon)
                        <a href="{{ $shortcode->button_secondary_url }}" class="sb-btn sb-btn-2 sb-btn-gray">
                        <span class="sb-icon">
                            <img src="{{ RvMedia::getImageUrl($shortcode->button_secondary_icon) }}" alt="{{ $shortcode->button_secondary_label }}">
                        </span>
                            <span>{!! BaseHelper::clean($shortcode->button_secondary_label) !!}</span>
                        </a>
                    @endif
                </div>
            </div>
            @if($image = $shortcode->image)
                <div class="col-lg-6">
                    <div class="sb-illustration-{{ $illustrationStyle }}">
                        <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $shortcode->title }}" @class(['sb-reserved' => $styleImage === 'service', 'sb-burger' => $styleImage === 'product'])>
                        <div class="sb-cirkle-1"></div>
                        <div class="sb-cirkle-2"></div>
                        <div class="sb-cirkle-3"></div>
                        <div class="sb-cirkle-4"></div>
                        <div class="sb-cirkle-5"></div>
                        <img src="{{ Theme::asset()->url('images/icons/illustrations/2.svg') }}" alt="icon" class="sb-pik-2">
                        <img src="{{ Theme::asset()->url('images/icons/illustrations/2.svg') }}" alt="icon" class="sb-pik-3">
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
