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
                            <h3 class="sb-mb-30">{{ __('Forgot Password') }}</h3>
                            <p class="sb-text mb-4">{{ __('Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.') }}</p>
                            <form method="post" action="{{ route('customer.password.request') }}">
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

                                <button class="sb-btn sb-cf-submit sb-show-success">
                                    <span class="sb-icon">
                                      <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="icon">
                                    </span>
                                    <span>{{ __('Send Password Reset Link') }}</span>
                                </button>
                            </form>
                            @if (session('status'))
                                <div class="text-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if (session('success_msg'))
                                <div class="text-success">
                                    {{ session('success_msg') }}
                                </div>
                            @endif

                            @if (session('error_msg'))
                                <div class="text-danger">
                                    {{ session('error_msg') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
