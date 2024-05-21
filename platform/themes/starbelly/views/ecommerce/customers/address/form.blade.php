<form action="{{ $url }}" method="post">
    @csrf
    <div class="sb-group-input">
        <input type="text" id="name" name="name" value="{{ old('name', $address) }}" required>
        <span class="sb-bar"></span>
        <label for="name">{{ __('Full name') }}</label>
        @error('name')
        <div class="sb-invalid">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="sb-group-input">
        <input type="email" id="email" name="email" value="{{ old('email', $address) }}" required>
        <span class="sb-bar"></span>
        <label for="name">{{ __('Email') }}</label>
        @error('email')
        <div class="sb-invalid">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="sb-group-input">
        <input type="tel" id="phone" name="phone" value="{{ old('phone', $address) }}" required>
        <span class="sb-bar"></span>
        <label for="phone">{{ __('Phone') }}</label>
        @error('phone')
        <div class="sb-invalid">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            @if (EcommerceHelper::isUsingInMultipleCountries())
                <div class="mb-3">
                    <label for="country" class="form-label">{{ __('Country') }}</label>
                    <select name="country" id="country" data-type="country" required class="form-select">
                        @foreach(EcommerceHelper::getAvailableCountries() as $countryCode => $countryName)
                            <option value="{{ $countryCode }}" @selected(old('country', $address) === $countryCode)>{{ $countryName }}</option>
                        @endforeach
                    </select>
                    @error('phone')
                    <div class="sb-invalid">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            @else
                <input type="hidden" name="country" value="{{ EcommerceHelper::getFirstCountryId() }}">
            @endif
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="state" class="form-label">{{ __('State') }}</label>
                @if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation())
                    <select name="state" id="state" data-type="state" required class="form-select">
                        @foreach(EcommerceHelper::getAvailableStatesByCountry() as $key => $value)
                            <option value="{{ $key }}" @selected(old('state', $address) === $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                @else
                    <input id="state" type="text" class="form-control" name="state" value="{{ old('state', $address) }}" placeholder="{{ __('Enter State') }}" required>
                @endif
                @error('state')
                <div class="sb-invalid">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="city" class="form-label">{{ __('City') }}</label>
                @if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation())
                    <select name="city" id="city" data-type="city" required class="form-select">
                        @foreach(EcommerceHelper::getAvailableStatesByCountry() as $key => $value)
                            <option value="{{ $key }}" @selected(old('city', $address) === $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                @else
                    <input id="city" type="text" class="form-control" name="city" value="{{ old('city', $address) }}" placeholder="{{ __('Enter city') }}" required>
                @endif
                @error('city')
                <div class="sb-invalid">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div @class(['col-md-8' => EcommerceHelper::isZipCodeEnabled(), 'col-md-12' => ! EcommerceHelper::isZipCodeEnabled()])>
            <div class="sb-group-input">
                <input type="text" id="address" name="address" value="{{ old('address', $address) }}" required>
                <span class="sb-bar"></span>
                <label for="phone">{{ __('Address') }}</label>
                @error('address')
                <div class="sb-invalid">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        @if (EcommerceHelper::isZipCodeEnabled())
            <div class="col-md-3">
                <div class="sb-group-input">
                    <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code', $address) }}">
                    <span class="sb-bar"></span>
                    <label for="zip_code">{{ __('Zip code') }}</label>
                    @error('zip_code')
                    <div class="sb-invalid">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        @endif
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_default" value="1" @checked(old('is_default', $address)) id="is-default">
            <label class="form-check-label" for="is-default">{{ __('Use this address as default?') }}</label>
        </div>
        @if ($errors->has('is_default'))
            <div class="invalid-feedback">
                {{ $errors->first('is_default') }}
            </div>
        @endif
    </div>

    <button type="submit" class="sb-btn sb-m-0">
        <span class="sb-icon">
            <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="{{ __('Update') }}">
        </span>
        <span>{{ __('Save address') }}</span>
    </button>
</form>
