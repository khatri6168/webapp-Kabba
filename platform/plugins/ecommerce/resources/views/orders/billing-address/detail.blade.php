<li>{{ $address->name }}</li>
@if ($address->phone)
    <li>
        <a href="tel:{{ $address->phone }}">
            <span><i class="fa fa-phone-square cursor-pointer mr5"></i></span>
            @php
           
                $custphone = substr($address->phone, 0, 7) . ' ' . substr($address->phone, 7);
                $custphone = ltrim($custphone, '+1'); 
                @endphp
            <span dir="ltr">{{ $address->phone }}</span>
        </a>
    </li>
@endif
<li>
    @if ($address->email)
        <div><a href="mailto:{{ $address->email }}">{{ $address->email }}</a></div>
    @endif
    @if ($address->address)
        <div>{!! BaseHelper::clean($address->address) !!}</div>
    @endif
    @if ($address->city)
        <div>{{ $address->city_name }}</div>
    @endif
    @if ($address->state)
        <div>{{ $address->state_name }}</div>
    @endif
    @if ($address->country_name)
        <div>{{ $address->country_name }}</div>
    @endif
    @if (EcommerceHelper::isZipCodeEnabled() && $address->zip_code)
        <div>{{ $address->zip_code }}</div>
    @endif
    @if($address->country || $address->state || $address->city || $address->address)
        <div>
            <a target="_blank" class="hover-underline" href="https://maps.google.com/?q={{ $address->address }}, {{ $address->city_name }}, {{ $address->state_name }}, {{ $address->country_name }}@if (EcommerceHelper::isZipCodeEnabled()), {{ $address->zip_code }} @endif">{{ trans('plugins/ecommerce::order.see_on_maps') }}</a>
        </div>
    @endif
</li>
