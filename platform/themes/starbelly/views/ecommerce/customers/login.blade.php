@php(Theme::set('withBreadcrumb', false))

<section class="sb-banner sb-banner-color mt-5 pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="sb-contact-form-frame">
                    <div class="sb-illustration-9">
                        <div class="sb-cirkle-1"></div>
                        <div class="sb-cirkle-2"></div>
                        <div class="sb-cirkle-3"></div>
                    </div>
                    <div class="sb-form-content">
                        <div class="sb-main-content">
                            <h3 class="sb-mb-30">{{ __('Login') }}</h3>
                            <form method="post" action="{{ route('customer.login.post') }}">
                                @csrf
                                <div class="sb-group-input">
                                    <input type="email" name="email" value="{{ old('email') }}" required>
                                    <span class="sb-bar"></span>
                                    <label>{{ __('Email') }}</label>
                                    @error('email')
                                    <div class="sb-invalid">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="sb-group-input">
                                    <input type="password" name="password" required>
                                    <span class="sb-bar"></span>
                                    <label>{{ __('Password') }}</label>
                                    @error('password')
                                    <div class="sb-invalid">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                @if (is_plugin_active('captcha') && setting('enable_captcha') && get_ecommerce_setting('enable_recaptcha_in_register_page', 0))
                                    <div class="sb-group-input">
                                        {!! Captcha::display() !!}
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between sb-text px-1">
                                    <div class="text-start sb-mb-30">
                                        <input type="checkbox" name="remember" id="remember" value="1" @checked(old('remember'))>
                                        <label for="remember">{{ __('Remember me') }}</label>
                                    </div>
                                    <a href="{{ route('customer.password.reset') }}">{{ __('Forgot password?') }}</a>
                                </div>
                                <button class="sb-btn sb-cf-submit sb-show-success">
                                    <span class="sb-icon">
                                      <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="icon">
                                    </span>
                                    <span>{{ __('Login') }}</span>
                                </button>
                            </form>

                            <p class="sb-text mt-4 pb-4 border-bottom">
                                {{ __("Don\'t have an account?") }}
                                <a href="{{  route('customer.register') }}" class="sb">{{ __('Sign up') }}</a>
                            </p>

                            {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\Ecommerce\Models\Customer::class) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
