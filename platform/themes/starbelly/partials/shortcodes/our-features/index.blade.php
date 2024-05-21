<section class="sb-p-60-0">
    <div class="container">
        <div class="row flex-md-row-reverse">
            <div class="col-lg-6 align-self-center sb-mb-30">
                @if($title = $shortcode->title)
                    <h2 class="sb-mb-60">{!! BaseHelper::clean($title) !!}</h2>
                @endif
                <ul class="sb-features">
                    @for($i = 1; $i <= 3; $i++)
                        <li class="sb-features-item sb-mb-60">
                            <div class="sb-number">0{{ $i }}</div>
                            <div class="sb-feature-text">
                                @if ($titleStep = $shortcode->{'title_' . $i})
                                    <h3 class="sb-mb-15">{!! BaseHelper::clean($titleStep) !!}</h3>
                                @endif

                                @if ($subtitleStep = $shortcode->{'subtitle_' . $i})
                                    <p class="sb-text">{!! BaseHelper::clean($subtitleStep) !!}</p>
                                @endif
                            </div>
                        </li>
                    @endfor
                </ul>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="sb-illustration-2 sb-mb-90">
                    @if($image = $shortcode->image)
                        <div class="sb-interior-frame">
                            <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ __('Interior') }}" class="sb-interior">
                        </div>
                    @endif
                    <div class="sb-square"></div>
                    <div class="sb-cirkle-1"></div>
                    <div class="sb-cirkle-2"></div>
                    <div class="sb-cirkle-3"></div>
                    <div class="sb-cirkle-4"></div>
                    @if ($yearExperience = $shortcode->year_experience)
                        <div class="sb-experience">
                            <div class="sb-exp-content">
                                <p class="sb-h1 sb-mb-10">{{ $yearExperience }}</p>
                                <p class="sb-h3">{{ __('Years Experience') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
