@php
    $crumbs = Theme::breadcrumb()->getCrumbs();
@endphp

<section class="sb-banner sb-banner-color">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="sb-main-title-frame">
                    <div class="sb-main-title">
                        <span class="sb-subtitle sb-mb-30">{{ __('Contact') }}</span>
                        @if ($title = $shortcode->title)
                            <h1 class="sb-mb-30">{!! BaseHelper::clean($title) !!}</h1>
                        @endif

                        @if ($subtitle = $shortcode->subtitle)
                            <p class="sb-text sb-text-lg sb-mb-30">{!! BaseHelper::clean($subtitle) !!}</p>
                        @endif
                        <ul class="sb-breadcrumbs">
                            @foreach ($crumbs as $i => $crumb)
                                <li>
                                    <a href="{{ Arr::get($crumb, 'url') }}">{!! BaseHelper::clean(Arr::get($crumb, 'label')) !!}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="sb-contact-form-frame">
                    <div class="sb-illustration-9">
                        @if ($primaryImage = $shortcode->primary_image)
                            <img src="{{ RvMedia::getImageUrl($primaryImage) }}" alt="{{ __('Contact') }}" class="sb-envelope-1">
                        @endif

                        @if ($secondaryImage = $shortcode->secondary_image)
                            <img src="{{ RvMedia::getImageUrl($secondaryImage) }}" alt="{{ __('Contact') }}" class="sb-envelope-2">
                        @endif
                        <div class="sb-cirkle-1"></div>
                        <div class="sb-cirkle-2"></div>
                        <div class="sb-cirkle-3"></div>
                    </div>
                    <div class="sb-form-content">
                        <div class="sb-main-content">
                            <h3 class="sb-mb-30">{{ __('Send Message') }}</h3>
                            <form id="form" method="post" action="{{ route('public.send.contact') }}" class="contact-form">
                                @csrf
                                <div class="sb-group-input">
                                    <input type="text" name="name" required="">
                                    <span class="sb-bar" style="height: 100%;"></span>
                                    <label>{{ __('Name') }}</label>
                                </div>
                                <div class="sb-group-input">
                                    <input type="email" name="email" required="">
                                    <span class="sb-bar" style="height: 100%;"></span>
                                    <label>{{ __('Email') }}</label>
                                </div>
                                <div class="sb-group-input">
                                    <textarea name="content" required=""></textarea>
                                    <span class="sb-bar" style="height: 100%;"></span>
                                    <label>{{ __('Message') }}</label>
                                </div>

                                {!! apply_filters('after_contact_form', null) !!}

                                <div class="contact-form-group">
                                    <div class="contact-message contact-success-message" style="display: none"></div>
                                    <div class="contact-message contact-error-message" style="display: none"></div>
                                </div>

                                <p class="sb-text sb-text-xs sb-mb-30">{!! __('*We promise not to disclose your <br>personal information to third parties.') !!}</p>
                                <button class="sb-btn sb-cf-submit sb-show-success" type="submit" id="submit">
                                    <span class="sb-icon">
                                      <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="{{ __('Send') }}">
                                    </span>
                                    <span>{{ __('Send') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
