<section class="sb-call-to-action">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="sb-cta-text">
                    @if ($title = $config['title'])
                        <h2 class="sb-h1 sb-mb-30">{!! BaseHelper::clean($title) !!}</h2>
                    @endif

                    @if($subtitle = $config['subtitle'])
                        <p class="sb-text sb-mb-30">{!! BaseHelper::clean($subtitle) !!}</p>
                    @endif
                    <form action="{{ route('public.newsletter.subscribe') }}" method="post" class="newsletter-form">
                        @csrf
                        <div class="sb-group-input position-relative">
                            <input class="newsletter-input" type="text" name="email" placeholder="{{ __('Enter you email') }}">
                            <span class="sb-bar"></span>
                            <button type="submit" class="sb-btn sb-cf-submit sb-show-success position-absolute button-send-newsletter">
                                    <span class="sb-icon">
                                      <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="{{ __('Submit') }}">
                                    </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sb-illustration-3">
                    @if ($image = $config['image'])
                        <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ __('Newsletter') }}" class="sb-phones">
                    @endif
                    <div class="sb-cirkle-1"></div>
                    <div class="sb-cirkle-2"></div>
                    <div class="sb-cirkle-3"></div>
                    <div class="sb-cirkle-4"></div>
                    <img src="{{ Theme::asset()->url('images/icons/illustrations/1.svg') }}" alt="{{ __('Icon') }}" class="sb-pik-1">
                    <img src="{{ Theme::asset()->url('images/icons/illustrations/1.svg') }}" alt="{{ __('Icon') }}" class="sb-pik-2">
                    <img src="{{ Theme::asset()->url('images/icons/illustrations/1.svg') }}" alt="{{ __('Icon') }}" class="sb-pik-3">
                </div>
            </div>
        </div>
    </div>
</section>
