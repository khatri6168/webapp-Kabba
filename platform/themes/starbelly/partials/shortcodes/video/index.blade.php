<section class="sb-video">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="sb-mb-90">
                    @if($badgeText = $shortcode->badge_text)
                        <span class="sb-subtitle sb-mb-15">{!! BaseHelper::clean($badgeText) !!}</span>
                    @endif
                    @if($title = $shortcode->title)
                        <h2 class="sb-mb-30">{!! BaseHelper::clean($title) !!}</h2>
                    @endif
                    <p class="sb-text sb-mb-30">{!! BaseHelper::clean($shortcode->description) !!}</p>
                    <a data-fancybox="video" data-no-swup href="{{ $shortcode->video_url }}" class="sb-btn">
                        <span class="sb-icon">
                            <img src="{{ Theme::asset()->url('images/icons/play.svg') }}" alt="{{ __('Play') }}">
                        </span>
                        <span>{!! BaseHelper::clean($shortcode->play_button_label) !!}</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="sb-illustration-7 sb-mb-90">
                    <div class="sb-interior-frame">
                        <img src="{{ RvMedia::getImageUrl($shortcode->video_thumbnail) }}" alt="{{ $title }}" class="sb-interior">
                        <a data-fancybox="video" data-no-swup href="{{ $shortcode->video_url }}" class="sb-video-play">
                            <i class="fas fa-play"></i>
                        </a>
                    </div>
                    <div class="sb-cirkle-1"></div>
                    <div class="sb-cirkle-2"></div>
                    <div class="sb-cirkle-3"></div>
                    <div class="sb-cirkle-4"></div>
                </div>
            </div>
        </div>
    </div>
</section>
