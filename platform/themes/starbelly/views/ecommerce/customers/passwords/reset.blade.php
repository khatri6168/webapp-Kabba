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
                            <h3 class="sb-mb-30">{{ __('Update Password') }}</h3>
                            <form method="post" action="{{ route('customer.password.reset.post') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}" />

                                <div class="sb-group-input">
                                    <input type="email" name="email" value="{{ old('email', $email) }}" required>
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

                                <button type="submit" class="sb-btn sb-cf-submit sb-show-success">
                                    <span class="sb-icon">
                                      <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="icon">
                                    </span>
                                    <span>{{ __('Submit') }}</span>
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
