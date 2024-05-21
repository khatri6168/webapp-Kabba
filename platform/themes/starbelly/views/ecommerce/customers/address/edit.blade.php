@extends(Theme::getThemeNamespace('views.ecommerce.customers.layout'))

@section('content')
    @include(Theme::getThemeNamespace('views.ecommerce.customers.address.form'), [
        'url' => route('customer.address.edit', $address->id),
    ])
@endsection
