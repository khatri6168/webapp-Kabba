@extends(Theme::getThemeNamespace('views.ecommerce.customers.layout'))

@section('content')
    <p>{{ __('The following addresses will be used on the checkout page by default.') }}</p>
    <div class="py-3">
        <div class="d-flex justify-content-between py-2">
            <h4>{{ SeoHelper::getTitle() }}</h4>
            <a class="text" href="{{ route('customer.address.create') }}">{{ __('Add') }}</a>
        </div>
        @include(Theme::getThemeNamespace('views.ecommerce.customers.address.items'))

        {!! $addresses->links() !!}
    </div>
@endsection
