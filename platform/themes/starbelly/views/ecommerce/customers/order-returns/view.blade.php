@extends(Theme::getThemeNamespace('views.ecommerce.customers.layout'))

@section('content')
    <div class="customer-order-detail">
        @include('plugins/ecommerce::themes.includes.order-return-form')
    </div>
@endsection
