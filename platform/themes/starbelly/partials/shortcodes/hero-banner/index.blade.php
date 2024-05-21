<section class="sb-banner">
    <div class="sb-bg-1">
        <div></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="sb-main-title-frame">
                    <div class="sb-main-title">
                        @if ($textSecondary = $shortcode->text_secondary)
                            <span class="sb-subtitle sb-mb-30">{!! BaseHelper::clean($textSecondary) !!}</span>
                        @endif

                        @if ($title = $shortcode->title)
                            <h1 class="sb-mb-30">{!! BaseHelper::clean($title) !!}</h1>
                        @endif

                        @if($subtitle = $shortcode->subtitle)
                            <p class="sb-text sb-text-lg sb-mb-30">{!! BaseHelper::clean($subtitle) !!}</p>
                        @endif
                        @if ($shortcode->button_label_1 || $shortcode->button_url_1)
                            <a href="{{ $shortcode->button_url_1 ?? '#' }}" class="sb-btn">
                                <span class="sb-icon">
                                  <img src="{{ Theme::asset()->url('images/icons/menu.svg') }}" alt="{{ $shortcode->button_label_1 ?? 'icon' }}">
                                </span>
                                <span>{{ $shortcode->button_label_1 ?? '' }}</span>
                            </a>
                        @endif
                        @if ($shortcode->button_label_2 || $shortcode->button_url_2)
                            <a href="{{ $shortcode->button_url_2 ?? '#' }}" class="sb-btn sb-btn-2 sb-btn-gray">
                                <span class="sb-icon">
                                  <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="{{ $shortcode->button_label_2 ?? 'icon' }}">
                                </span>
                                <span>{{ $shortcode->button_label_2 ?? '' }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                @switch((int)$shortcode->style)
                    @case(1)
                        <div class="sb-illustration-1">
                            @if ($image = $shortcode->image)
                                <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $image }}" class="sb-girl">
                            @endif
                            <div class="sb-cirkle-1"></div>
                            <div class="sb-cirkle-2"></div>
                            <div class="sb-cirkle-3"></div>
                            <div class="sb-cirkle-4"></div>
                            <div class="sb-cirkle-5"></div>
                            <img src="{{ Theme::asset()->url('images/icons/illustrations/3.svg') }}" alt="{{ __('icon') }}" class="sb-pik-1">
                            <img src="{{ Theme::asset()->url('images/icons/illustrations/1.svg') }}" alt="{{ __('icon') }}" class="sb-pik-2">
                            <img src="{{ Theme::asset()->url('images/icons/illustrations/2.svg') }}" alt="{{ __('icon') }}" class="sb-pik-3">
                        </div>
                        @break
                    @case(2)
                        <div class="sb-ilustration-fix">
                            <div class="sb-illustration-1-2">
                                @foreach(range(1, 3) as $i)
                                    @if($image = $shortcode->{'image_' . $i})
                                        <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $shortcode->title }}" class="sb-food-{{ $i }}">
                                    @endif
                                @endforeach
                                @foreach(range(1, 2) as $i)
                                    @if($message = $shortcode->{'message_' . $i})
                                        <div class="sb-illu-dialog-{{ $i }}">{!! BaseHelper::clean($message) !!}</div>
                                    @endif
                                @endforeach
                                <div class="sb-cirkle-1"></div>
                                <div class="sb-cirkle-2"></div>
                                <div class="sb-cirkle-3"></div>
                                <div class="sb-cirkle-4"></div>
                                <div class="sb-cirkle-5"></div>
                                <img src="{{ Theme::asset()->url('images/icons/illustrations/3.svg') }}" alt="{{ __('icon') }}" class="sb-pik-1">
                                <img src="{{ Theme::asset()->url('images/icons/illustrations/1.svg') }}" alt="{{ __('icon') }}" class="sb-pik-2">
                                <img src="{{ Theme::asset()->url('images/icons/illustrations/2.svg') }}" alt="{{ __('icon') }}" class="sb-pik-3">
                            </div>
                        </div>
                        @break
                @endswitch
            </div>
        </div>
    </div>
</section>
