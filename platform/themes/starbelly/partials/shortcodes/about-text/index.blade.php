<section class="sb-about-text sb-p-90-0">
    <div class="sb-bg-2" style="margin-top: 90px">
        <div></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="sb-illustration-2 sb-mb-90">
                    <div class="sb-interior-frame">
                        <img src="{{ RvMedia::getImageUrl($shortcode->image) }}" alt="interior" class="sb-interior" style="object-position: center">
                    </div>
                    <div class="sb-square"></div>
                    <div class="sb-cirkle-1"></div>
                    <div class="sb-cirkle-2"></div>
                    <div class="sb-cirkle-3"></div>
                    <div class="sb-cirkle-4"></div>
                    @if($shortcode->experience_year || $shortcode->experience_text)
                        <div class="sb-experience">
                            <div class="sb-exp-content">
                                <p class="sb-h1 sb-mb-10">{!! BaseHelper::clean($shortcode->experience_year) !!}</p>
                                <p class="sb-h3">{!! BaseHelper::clean($shortcode->experience_text) !!}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 align-self-center sb-mb-60">
                @if($shortcode->title)
                    <h2 class="sb-mb-60">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                @endif

                @if($shortcode->text)
                    <p class="sb-text sb-mb-30">{!! BaseHelper::clean($shortcode->text) !!}</p>
                @endif

                @if($shortcode->text_image)
                    <img src="{{ RvMedia::getImageUrl($shortcode->text_image) }}" alt="{{ $shortcode->title }}" class="sb-signature sb-mb-30">
                @endif
            </div>
        </div>
    </div>
</section>
