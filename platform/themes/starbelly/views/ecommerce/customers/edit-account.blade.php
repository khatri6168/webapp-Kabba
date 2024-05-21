@php($user = auth('customer')->user())

@extends(Theme::getThemeNamespace('views.ecommerce.customers.layout'))

@section('content')
    <form action="{{ route('customer.edit-account') }}" method="post">
        @csrf
        <div class="sb-group-input">
            <input type="text" id="name" name="name" value="{{ old('name', $user) }}">
            <span class="sb-bar"></span>
            <label for="name">{{ __('Full name') }}</label>
            @error('name')
            <div class="sb-invalid">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="sb-group-input">
            <input type="email" id="email" name="email" value="{{ old('email', $user) }}" disabled>
            <span class="sb-bar"></span>
            <label for="email">{{ __('Email') }}</label>
            @error('email')
            <div class="sb-invalid">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="sb-group-input">
            <input type="tel" id="phone" name="phone" value="{{ old('phone', $user) }}">
            <span class="sb-bar"></span>
            <label for="phone">{{ __('Phone') }}</label>
            @error('phone')
            <div class="sb-invalid">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="sb-group-input">
            <input type="date" id="dob" name="dob" value="{{ old('dob', $user) }}">
            <span class="sb-bar"></span>
            <label for="dob">{{ __('Date of birth') }}</label>
            @error('dob')
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
