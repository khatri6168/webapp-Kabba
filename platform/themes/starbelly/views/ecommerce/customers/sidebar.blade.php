@php
    $menus = [
        'customer.overview' => [
            'label' => __('Overview'),
        ],
        'customer.edit-account' => [
            'label' => __('Profile'),
        ],
        'customer.orders' => [
            'label'  => __('Orders'),
            'routes' => ['customer.orders.view']
        ],
        'customer.downloads' => [
            'label' => __('Downloads'),
        ],
        'customer.order_returns' => [
            'label'  => __('Order Return Requests'),
            'routes' => ['customer.order_returns', 'customer.order_returns.detail']
        ],
        'customer.address' => [
            'label'  => __('Addresses'),
            'routes' => [
                'customer.address.create',
                'customer.address.edit'
            ]
        ],
        'customer.change-password' => [
            'label' => __('Change password'),
        ],
        'customer.logout' => [
            'label' => __('Logout'),
        ],
    ];

    if (is_plugin_active('marketplace')) {
        if (auth('customer')->user()->is_vendor) {
            $menus[] = [
                'marketplace.vendor.dashboard' => [
                    'label' => __('Vendor dashboard'),
                ],
                'marketplace.vendor.become-vendor' => [
                    'label' => __('Become a vendor'),
                ]
            ];
        }
    }

    $routeName = Route::currentRouteName();

    if (! EcommerceHelper::isEnabledSupportDigitalProducts()) {
        Arr::forget($menus, 'customer.downloads');
    }

    if (! EcommerceHelper::isOrderReturnEnabled()) {
        Arr::forget($menus, 'customer.order_returns');
    }
@endphp

<div class="col-lg-3 mb-3 mb-md-0">
    <div class="sb-pad-type-2">
        <form id="avatar-upload-form" enctype="multipart/form-data" action="javascript:void(0)" onsubmit="return false">
            <div class="avatar-upload-container">
                <div class="form-group mb-3">
                    <div id="account-avatar">
                        <div class="profile-image">
                            <div class="avatar-view mt-card-avatar">
                                <img class="br2" src="{{ auth('customer')->user()->avatar_url }}" alt="{{ auth('customer')->user()->name }}">
                                <div class="mt-overlay br2">
                                    <span><i class="fa fa-edit"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="print-msg" class="text-danger hidden"></div>
            </div>
        </form>
        <p class="text-center">{{ auth('customer')->user()->email }}</p>

        <div class="list-group sb-customer-sidebar">
            @foreach($menus as $key => $menu)
                <a href="{{ route($key) }}" @class(['list-group-item list-group-item-action', 'active' => $routeName === $key || in_array($routeName, Arr::get($menu, 'routes', []))])>
                    {{ Arr::get($menu, 'label') }}
                </a>
            @endforeach
        </div>
    </div>
</div>
