<section class="sb-call-to-action">
    <div class="sb-bg-3"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="sb-cta-text">
                    @if ($title = $shortcode->title)
                        <h2 class="sb-h1 sb-mb-30">{!! BaseHelper::clean($title) !!}</h2>
                    @endif

                    @if ($subtitle = $shortcode->subtitle)
                        <p class="sb-text sb-mb-30">{!! BaseHelper::clean($subtitle) !!}</p>
                    @endif

                    @foreach(range(1, 3) as $i)
                        @if ($shortcode->{'platform_button_image_' . $i} || $shortcode->{'platform_url_' . $i} || $shortcode->{'platform_name_' . $i})
                            <a href="{{ $shortcode->{'platform_url_' . $i} ?? '#' }}" target="_blank" data-no-swup="" class="sb-download-btn">
                                @if($platformImage = $shortcode->{'platform_button_image_' . $i})
                                    <img src="{{ RvMedia::getImageUrl($platformImage) }}" alt="{{ $platformName ?? __('Platform image') }}">
                                @elseif ($platformName = $shortcode->{'platform_name_' . $i})
                                    {!! BaseHelper::clean($platformName) !!}
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sb-illustration-3">
                    @if ($image = $shortcode->image)
                        <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ __('Image apps download') }}" class="sb-phones">
                    @endif
                    <div class="sb-cirkle-1"></div>
                    <div class="sb-cirkle-2"></div>
                    <div class="sb-cirkle-3"></div>
                    <div class="sb-cirkle-4"></div>
                    <img src="{{ Theme::asset()->url('images/icons/illustrations/1.svg') }}" alt="{{ __('icon') }}" class="sb-pik-1">
                    <img src="{{ Theme::asset()->url('images/icons/illustrations/1.svg') }}" alt="{{ __('icon') }}" class="sb-pik-2">
                    <img src="{{ Theme::asset()->url('images/icons/illustrations/1.svg') }}" alt="{{ __('icon') }}" class="sb-pik-3">
                </div>
            </div>
        </div>
    </div>
</section>
