<section class="sb-call-to-action">
    <div class="sb-bg-3"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="sb-cta-text">
                    @if($title = Arr::get($config, 'title'))
                        <h2 class="sb-h1 sb-mb-15">{!! BaseHelper::clean($title) !!}</h2>
                    @endif
                    @if($description = Arr::get($config, 'description'))
                        <p class="sb-text sb-mb-30">{!! BaseHelper::clean($description) !!}</p>
                    @endif
                   @if($label = Arr::get($config, 'button_primary_label'))
                        <a href="{{ Arr::get($config, 'button_primary_url') }}" class="sb-btn">
                        <span class="sb-icon">
                            <img src="{{ RvMedia::getImageUrl(Arr::get($config, 'button_primary_icon')) }}" alt="icon">
                        </span>
                            <span>{{ $label }}</span>
                        </a>
                   @endif
                    @if($label = Arr::get($config, 'button_secondary_label'))
                        <a href="{{ Arr::get($config, 'button_secondary_url') }}" class="sb-btn sb-btn-2 sb-btn-gray">
                        <span class="sb-icon">
                            <img src="{{ RvMedia::getImageUrl(Arr::get($config, 'button_secondary_icon')) }}" alt="icon">
                        </span>
                            <span>{{ $label }}</span>
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sb-illustration-8">
                    @if($image = Arr::get($config, 'image'))
                        <img src="{{ RvMedia::getImageUrl($image) }}" alt="reserved" class="sb-reserved">
                    @endif
                    <div class="sb-cirkle-1"></div>
                    <div class="sb-cirkle-2"></div>
                    <div class="sb-cirkle-3"></div>
                    <div class="sb-cirkle-4"></div>
                    <div class="sb-cirkle-5"></div>
                    <img src="{{ Theme::asset()->url('images/icons/illustrations/2.svg') }}" alt="icon" class="sb-pik-2">
                    <img src="{{ Theme::asset()->url('images/icons/illustrations/3.svg') }}" alt="icon" class="sb-pik-3">
                </div>
            </div>
        </div>
    </div>
</section>
