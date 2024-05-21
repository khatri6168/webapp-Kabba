<div class="customer-address-payment-form">
    @if (EcommerceHelper::isEnabledGuestCheckout() && ! auth('customer')->check())
        <div class="form-group mb-3">
            <p>{{ __('Already have an account?') }} <a href="{{ route('customer.login') }}">{{ __('Login') }}</a></p>
        </div>
    @endif

    @auth('customer')
        <div class="form-group mb-3">
            @if ($isAvailableAddress)
                <label class="control-label mb-2" for="address_id">{{ __('Select available addresses') }}:</label>
            @endif
            @php
                $oldSessionAddressId = old('address.address_id', $sessionAddressId);
            @endphp
            <div class="list-customer-address @if (! $isAvailableAddress) d-none @endif">
                <div class="select--arrow">
                    <select name="address[address_id]" class="form-control" id="address_id">
                        <option value="new" @selected ($oldSessionAddressId == 'new')>{{ __('Add new address...') }}</option>
                        @if ($isAvailableAddress)
                            @foreach ($addresses as $address)
                                <option value="{{ $address->id }}" data-first-name="{{$address->first_name}}" data-last-name="{{$address->last_name}}" @selected ($oldSessionAddressId == $address->id)>{{ $address->full_address }}</option>
                            @endforeach
                        @endif
                    </select>
                    <i class="fas fa-angle-down"></i>
                </div>
                <br>
                <div class="address-item-selected @if (! $sessionAddressId) d-none @endif">
                    @if ($isAvailableAddress && $oldSessionAddressId != 'new')
                        @if ($oldSessionAddressId && $addresses->contains('id', $oldSessionAddressId))
                            @include('plugins/ecommerce::orders.partials.address-item', ['address' => $addresses->firstWhere('id', $oldSessionAddressId)])
                        @elseif ($defaultAddress = get_default_customer_address())
                            @include('plugins/ecommerce::orders.partials.address-item', ['address' => $defaultAddress])
                        @else
                            @include('plugins/ecommerce::orders.partials.address-item', ['address' => Arr::first($addresses)])
                        @endif
                    @endif
                </div>
                <div class="list-available-address d-none">
                    @if ($isAvailableAddress)
                        @foreach($addresses as $address)
                            <div class="address-item-wrapper" data-id="{{ $address->id }}">
                                @include('plugins/ecommerce::orders.partials.address-item', compact('address'))
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endauth

    <div class="address-form-wrapper @if (auth('customer')->check() && $oldSessionAddressId !== 'new' && $isAvailableAddress) d-none @endif">
        <div class="row">
            <div class="col-md-6 form-group mb-3 @error('address.first_name') has-error @enderror">
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        name="address[first_name]"
                        id="address_first_name"
                        class="form-control"
                        required
                        value="{{ old('address.first_name', Arr::get($sessionCheckoutData, 'first_name')) ?: (auth('customer')->check() ? auth('customer')->user()->first_name : null) }}"
                    >
                    <label for='address_name'>{{ __('First Name') }}</label>
                </div>
                {!! Form::error('address.first_name', $errors) !!}
            </div>
            <div class="col-md-6 form-group mb-3 @error('address.last_name') has-error @enderror">
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        name="address[last_name]"
                        id="address_last_name"
                        class="form-control"
                        required
                        value="{{ old('address.last_name', Arr::get($sessionCheckoutData, 'last_name')) ?: (auth('customer')->check() ? auth('customer')->user()->last_name : null) }}"
                    >
                    <label for='address_name'>{{ __('Last Name') }}</label>
                </div>
                {!! Form::error('address.last_name', $errors) !!}
            </div>
        </div>

        {{-- <div class="address-form-wrapper @if (auth('customer')->check() && $oldSessionAddressId !== 'new' && $isAvailableAddress) d-none @endif">
            <div class="form-group mb-3 @error('address.name') has-error @enderror">
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        name="address[name]"
                        id="address_name"
                        class="form-control"
                        required
                        value="{{ old('address.name', Arr::get($sessionCheckoutData, 'name')) ?: (auth('customer')->check() ? auth('customer')->user()->name : null) }}"
                    >
                    <label for='address_name'>{{ __('Full Name') }}</label>
                </div>
                {!! Form::error('address.name', $errors) !!}
        </div> --}}

        <div class="row">
            @if(! in_array('email', EcommerceHelper::getHiddenFieldsAtCheckout()))
                <div @class(['col-12', 'col-lg-8' => ! in_array('phone', EcommerceHelper::getHiddenFieldsAtCheckout())])>
                    <div class="form-group mb-3 @error('address.email') has-error @enderror">
                        <div class="form-input-wrapper">
                            <input type="email" name="address[email]" id="address_email"
                                class="form-control"
                                @if(auth('customer')->check()) readonly @endif
                                required
                                value="{{ old('address.email', Arr::get($sessionCheckoutData, 'email')) ?: (auth('customer')->check() ? auth('customer')->user()->email : null) }}">
                            <label for='address_email'>{{ __('Email') }}</label>
                        </div>
                        {!! Form::error('address.email', $errors) !!}
                    </div>
                </div>
            @endif
            @if(! in_array('phone', EcommerceHelper::getHiddenFieldsAtCheckout()))
                <div @class(['col-12', 'col-lg-4' => ! in_array('email', EcommerceHelper::getHiddenFieldsAtCheckout())])>
                    <div class="form-group mb-3">
                        <div class="form-input-wrapper">
                            <input
                                type="text"
                                name="address[phone]"
                                id="address_phone_1"
                                class="form-control"
                                value="{{ old('address.phone', Arr::get($sessionCheckoutData, 'phone')) ?: (auth('customer')->check() ? auth('customer')->user()->phone : null) }}"
                            >
                            <label for='address_phone'>{{ __('Phone') }}</label>
                        </div>
                        {!! Form::error('address.phone', $errors) !!}
                    </div>
                </div>
            @endif
        </div>

        @if(! in_array('address', EcommerceHelper::getHiddenFieldsAtCheckout()))
            <div class="form-group mb-3 @error('address.address') has-error @enderror">
                <div class="form-input-wrapper">
                    <input id="address_address" type="text" class="form-control" required name="address[address]" value="{{ old('address.address', Arr::get($sessionCheckoutData, 'address')) }}" autocomplete="false">
                    <label for='address_address'>{{ __('Address') }}</label>
                </div>
                {!! Form::error('address.address', $errors) !!}
            </div>
        @endif

        @if(! in_array('country', EcommerceHelper::getHiddenFieldsAtCheckout()))
            @if (EcommerceHelper::isUsingInMultipleCountries())
                <div class="form-group mb-3 @error('address.country') has-error @enderror">
                    <div class="select--arrow form-input-wrapper">
                        <select name="address[country]" class="form-control" required
                                data-form-parent=".customer-address-payment-form" id="address_country" data-type="country">
                            @foreach(EcommerceHelper::getAvailableCountries() as $countryCode => $countryName)
                                <option value="{{ $countryCode }}" @if (old('address.country', Arr::get($sessionCheckoutData, 'country')) == $countryCode) selected @endif>{{ $countryName }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-angle-down"></i>
                        <label for='address_country'>{{ __('Country') }}</label>
                    </div>
                    {!! Form::error('address.country', $errors) !!}
                </div>
            @else
                <input type="hidden" name="address[country]" id="address_country" value="{{ EcommerceHelper::getFirstCountryId() }}">
            @endif
        @endif

        <div class="row">
            @if(! in_array('state', EcommerceHelper::getHiddenFieldsAtCheckout()))
                <div class="col-sm-4 col-12">
                    <div class="form-group mb-3 @error('address.state') has-error @enderror">
                        @if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation())
                            <div class="select--arrow form-input-wrapper">
                                <select name="address[state]" class="form-control" required
                                    data-form-parent=".customer-address-payment-form" id="address_state" data-type="state" data-url="{{ route('ajax.states-by-country') }}">
                                    <option value="">{{ __('Select state...') }}</option>
                                    @if (old('address.country', Arr::get($sessionCheckoutData, 'country')) || !EcommerceHelper::isUsingInMultipleCountries())
                                        @foreach(EcommerceHelper::getAvailableStatesByCountry(old('address.country', Arr::get($sessionCheckoutData, 'country'))) as $stateId => $stateName)
                                            <option value="{{ $stateId }}" @if (old('address.state', Arr::get($sessionCheckoutData, 'state')) == $stateId) selected @endif>{{ $stateName }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <i class="fas fa-angle-down"></i>
                                <label for='address_state'>{{ __('State') }}</label>
                            </div>
                        @else
                        <div class="select--arrow form-input-wrapper">
                            @php
                                $states = \DB::table('states')->where('country_id', 1)->pluck('name', 'id');
                            @endphp
                            <select name="address[state]" class="form-control" required id="address_state">
                                <option value="" selected>Select State...</option>
                                @foreach ($states as $key => $stateName)
                                    <option value="{{$stateName}}"  @if (old('address.state', Arr::get($sessionCheckoutData, 'state')) == $stateName) selected @endif>{{ $stateName }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-angle-down"></i>
                            <label for='address_state'>{{ __('State') }}</label>
                        </div>
                            {{-- <div class="form-input-wrapper">
                                <input id="address_state" type="text" class="form-control" required name="address[state]" value="{{ old('address.state', Arr::get($sessionCheckoutData, 'state')) }}">
                                <label for='address_state'>{{ __('State') }}</label>
                            </div> --}}
                        @endif
                        {!! Form::error('address.state', $errors) !!}
                    </div>
                </div>
            @endif

            @if(! in_array('city', EcommerceHelper::getHiddenFieldsAtCheckout()))
                <div class="col-sm-4 col-12">
                    <div class="form-group mb-3 @error('address.city') has-error @enderror">
                        @if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation())
                            <div class="select--arrow form-input-wrapper">
                                <select name="address[city]" class="form-control" required id="address_city" data-type="city" data-url="{{ route('ajax.cities-by-state') }}">
                                    <option value="">{{ __('Select city...') }}</option>
                                    @if (old('address.state', Arr::get($sessionCheckoutData, 'state')))
                                        @foreach(EcommerceHelper::getAvailableCitiesByState(old('address.state', Arr::get($sessionCheckoutData, 'state'))) as $cityId => $cityName)
                                            <option value="{{ $cityId }}" @if (old('address.city', Arr::get($sessionCheckoutData, 'city')) == $cityId) selected @endif>{{ $cityName }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <i class="fas fa-angle-down"></i>
                                <label for='address_city'>{{ __('City') }}</label>
                            </div>
                        @else
                            <div class="form-input-wrapper">
                                <input id="address_city" type="text" class="form-control" required name="address[city]" value="{{ old('address.city', Arr::get($sessionCheckoutData, 'city')) }}">
                                <label for='address_city'>{{ __('City') }}</label>
                            </div>
                        @endif
                        {!! Form::error('address.city', $errors) !!}
                    </div>
                </div>
            @endif

            @if (EcommerceHelper::isZipCodeEnabled())
            <div class="col-sm-4 col-12">
                <div class="form-group mb-3 @error('address.zip_code') has-error @enderror">
                    <div class="form-input-wrapper">
                        <input id="address_zip_code" type="text"
                            class="form-control" name="address[zip_code]"
                        required
                            value="{{ old('address.zip_code', Arr::get($sessionCheckoutData, 'zip_code')) }}">
                        <label for='address_zip_code'>{{ __('Zip code') }}</label>
                    </div>
                    {!! Form::error('address.zip_code', $errors) !!}
                </div>
            </div>
        @endif
        </div>
    </div>

    @if (! auth('customer')->check())
        <div class="form-group mb-3">
            <input type="checkbox" name="create_account" value="1" id="create_account" checked {{--@if (old('create_account') == 1) checked @endif--}}>
            <label for="create_account" class="control-label ps-2">{{ __('Register an account with above information?') }}</label>
        </div>

        <div class="password-group {{--@if (! $errors->has('password') && ! $errors->has('password_confirmation')) d-none @endif--}}">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="form-group  @error('password') has-error @enderror">
                        <div class="form-input-wrapper">
                            <input id="password" type="password" class="form-control" name="password" autocomplete="password">
                            <label for='password'>{{ __('Password') }}</label>
                        </div>
                        {!! Form::error('password', $errors) !!}
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-group @error('password_confirmation') has-error @enderror">
                        <div class="form-input-wrapper">
                            <input id="password-confirm" type="password" class="form-control" autocomplete="password-confirmation" name="password_confirmation">
                            <label for='password-confirm'>{{ __('Password confirmation') }}</label>
                        </div>
                        {!! Form::error('password_confirmation', $errors) !!}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
<script>
    $(document).ready(function() {
        //alert('hi');
        // Initialize Inputmask with the desired phone number format
        setTimeout(() => {
            $('#address_phone_1').inputmask('(999) 999-9999');
        }, 2000);

        // Add a keyup event listener to update the value with the "+1" prefix
        $('#address_phone_1').on('keyup', function() {
            //alert('hi');
            var inputValue = $(this).val();
            if (inputValue.length === 10) {
                // If the input has 10 digits, add the "+1" prefix
                $(this).val(inputValue);
            }
        });

        $(document).on('input', '#address_first_name, #address_last_name', function() {
            let firstname = $('#address_first_name').val().trim();
            let lastName = $('#address_last_name').val().trim();
            let fullName = firstname + " " + lastName; // Added a "+" to concatenate the two strings correctly.
            $('input[data-stripe="first-name"]').val(firstname);
            $('input[data-stripe="last-name"]').val(lastName);
            $('.jp-card-name').text(fullName);
        });

        $('#create_account').on('click', function () {
            if ($('#create_account')[0].checked == true) {
                $('#create_account')[0].value = 1;
            } else {
                $('#create_account')[0].value = 0;
            }
        });
    });
</script>
@endpush
