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
                            <h3 class="sb-mb-30">{{ __('Sign up') }}</h3>
                            <form method="post" action="{{ route('customer.register.post') }}">
                                @csrf
                                <div class="sb-group-input">
                                    <input type="text" name="name" value="{{ old('name') }}" required>
                                    <span class="sb-bar"></span>
                                    <label>{{ __('Name') }}</label>
                                    @error('name')
                                    <div class="sb-invalid">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

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

                                <div class="sb-group-input">
                                    <input type="password" name="password_confirmation" required>
                                    <span class="sb-bar"></span>
                                    <label>{{ __('Password Confirmation') }}</label>
                                    @error('password_confirmation')
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

                                <p class="sb-text sb-text-xs sb-mb-30">
                                    {{ __('Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy.') }}
                                </p>

                                <div class="text-start sb-text ml-2 sb-mb-30 agree-terms-checkbox">
                                    <input type="checkbox" name="agree_terms_and_policy" id="agree-terms-and-policy" value="1" @checked(old('agree_terms_and_policy'))>
                                    <label for="agree-terms-and-policy">{{ __('I agree to terms & Policy.') }}</label>
                                </div>
                                <button class="sb-btn sb-cf-submit sb-show-success">
                                    <span class="sb-icon">
                                      <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="icon">
                                    </span>
                                    <span>{{ __('Register') }}</span>
                                </button>
                            </form>

                            <p class="sb-text mt-4 pb-4 border-bottom">
                                {{ __('Already have an account?') }}
                                <a href="{{  route('customer.login') }}" class="sb">{{ __('Login') }}</a>
                            </p>

                            {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\Ecommerce\Models\Customer::class) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
