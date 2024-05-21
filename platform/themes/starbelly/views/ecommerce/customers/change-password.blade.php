@extends(Theme::getThemeNamespace('views.ecommerce.customers.layout'))

@section('content')
    <form action="{{ route('customer.post.change-password') }}" method="post">
        @csrf
        <div class="sb-group-input">
            <input type="password" id="old_password" name="old_password" required>
            <span class="sb-bar"></span>
            <label for="old_password">{{ __('Current password') }}</label>
            @error('old_password')
            <div class="sb-invalid">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="sb-group-input">
            <input type="password" id="password" name="password" required>
            <span class="sb-bar"></span>
            <label for="password">{{ __('New password') }}</label>
            @error('password')
            <div class="sb-invalid">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="sb-group-input">
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            <span class="sb-bar"></span>
            <label for="password_confirmation">{{ __('Password confirmation') }}</label>
            @error('password_confirmation')
            <div class="sb-invalid">
                {{ $message }}
            </div>
            @enderror
        </div>
        <button type="submit" class="sb-btn sb-m-0">
            <span class="sb-icon">
                <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="{{ __('Update') }}">
            </span>
            <span>{{ __('Update') }}</span>
        </button>
    </form>
@endsection
