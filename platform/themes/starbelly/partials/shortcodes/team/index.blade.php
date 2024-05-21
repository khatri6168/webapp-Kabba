<section class="sb-p-0-60">
    <div class="container">
        <div class="sb-group-title sb-mb-30">
            <div class="sb-left sb-mb-30">
                @if ($title = $shortcode->title)
                    <h2 class="sb-mb-30">{!! BaseHelper::clean($title) !!}</h2>
                @endif

                @if($subtitle = $shortcode->subtitle)
                    <p class="sb-text">{!! BaseHelper::clean($subtitle) !!}</p>
                @endif
            </div>
            @if ($shortcode->button_label || $shortcode->button_url)
                <div class="sb-right sb-mb-30">
                    <a href="{{ $shortcode->button_url ?? '#' }}" class="sb-btn sb-m-0">
                        <span class="sb-icon">
                            <img src="{{ RvMedia::getImageUrl($shortcode->button_icon) }}" alt="{{ $shortcode->button_label }}">
                        </span>
                        <span>{!! BaseHelper::clean($shortcode->button_label ?? __('Go shipping now')) !!}</span>
                    </a>
                </div>
            @endif
        </div>
        @if($teams->isNotEmpty())
            <div class="row">
                @foreach($teams as $team)
                    <div @class(['col-lg-3' => count($teams) >= 4, 'col-lg-4' => count($teams) === 3])>
                        <div class="sb-team-member sb-mb-30">
                            <div class="sb-photo-frame sb-mb-15">
                                <img src="{{ RvMedia::getImageUrl($team->photo) }}" alt="{{ $team->name }}">
                            </div>
                            <div class="sb-member-description">
                                <h3 class="sb-mb-10">{!! BaseHelper::clean($team->name) !!}</h3>
                                <p class="sb-text sb-text-sm sb-mb-10">{!! BaseHelper::clean($team->title) !!}</p>
                                @php($socials = json_decode($team->socials, true))
                                <ul class="sb-social">
                                    @foreach(['facebook', 'twitter', 'instagram'] as $social)
                                        @if($url = Arr::get($socials, $social))
                                            <li>
                                                <a href="{{ $url }}">
                                                    <i class="fab fa-{{ $social }}"></i>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
