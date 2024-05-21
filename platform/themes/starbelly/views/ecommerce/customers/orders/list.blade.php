@extends(Theme::getThemeNamespace('views.ecommerce.customers.layout'))

@section('content')
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{ __('ID number') }}</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Total') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($orders as $order)
                @php
                    $productIds = $order->products()->pluck('product_id')->toArray();
                    $terms_selected = \Botble\Ecommerce\Models\Product::whereIn('id', $productIds)->where(function ($q) {
                        $q->where('use_global', 1)->orWhere('terms_id', '!=', null);
                    })->count();
                @endphp
                <tr>
                    <th scope="row">{{ get_order_code($order->id) }}</th>
                    <td>{{ $order->created_at->translatedFormat('M d, Y h:m') }}</td>
                    <td>{{ format_price($order->amount) }}</td>
                    <td>{!! BaseHelper::clean($order->status->toHtml()) !!}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('customer.orders.view', $order->id) }}">{{ __('View') }}</a>
                        @if ($terms_selected > 0)
                            @if ($order->terms_signed != 1)
                                <a class="btn btn-warning btn-sm" href="{{ route('public.checkout.sign-terms', $order->token) }}">{{ __('Terms') }}</a>
                            @else
                                <a class="btn btn-success btn-sm" href="{{ route('public.checkout.sign-terms', $order->token) }}?user=true">{{ __('Terms') }}</a>
                            @endif
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">{{ __('No orders!') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
@endsection
