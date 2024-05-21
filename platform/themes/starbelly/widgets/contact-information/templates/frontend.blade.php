<div>
    <div class="sb-ib-title-frame sb-mb-30">
        <h4>{{ $config['title'] }}</h4>
        <i class="fas fa-arrow-down"></i>
    </div>
    <ul class="sb-list sb-mb-30">
        @if($config['address'])
            <li><b>{{ __('Address:') }}</b><span title="{!! BaseHelper::clean($config['address']) !!}">{!! Str::limit(BaseHelper::clean($config['address']), 30) !!}</span></li>
        @endif

        @if ($config['working_hours_start'] && $config['working_hours_end'])
            <li><b>{{ __('Working hours:') }}</b><span>{{ $config['working_hours_start'] }} - {{ $config['working_hours_end'] }}</span></li>
        @endif

        @if ($config['phone'])
            <li><b>{{ __('Phone:') }}</b><span>{{ $config['phone'] }}</span></li>
        @endif

        @if($config['email'])
            <li><b>{{ __('Email:') }}</b><span>{{ $config['email'] }}</span></li>
        @endif
    </ul>
</div>
