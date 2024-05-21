<div class="row">
    @forelse ($addresses as $address)
        <div class="col-md-6">
            <address class="border rounded p-2">
                <p>{{ $address->name }}</p>
                <p>{{ $address->address }}</p>
                <p>{{ $address->city }}, {{ $address->state }}@if (EcommerceHelper::isUsingInMultipleCountries()), {{ $address->country_name }} @endif @if (EcommerceHelper::isZipCodeEnabled()), {{ $address->zip_code }} @endif</p>
                <p>{{ $address->phone }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a class="text-primary small" href="{{ route('customer.address.edit', $address->id) }}">{{ __('Edit') }}</a>
                        <a class="text-danger btn-trigger-delete-address ms-2 small" href="#" data-url="{{ route('customer.address.destroy', $address->id) }}">{{ __('Remove') }}</a>
                    </div>
                    @if ($address->is_default)
                        <span class="badge bg-primary">{{ __('Default address') }}</span>
                    @endif
                </div>
            </address>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                <span class="fst-italic">{{ __('You have not set up this type of address yet.') }}</span>
            </div>
        </div>
    @endforelse
</div>

@php(Theme::set('footer', view(Theme::getThemeNamespace('views.ecommerce.customers.includes.delete-modal'))->render()))
