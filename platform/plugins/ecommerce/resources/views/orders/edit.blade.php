@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="row">
        <div class="col-md-8 col-sm-12">
            @if(!empty($delivery))
                @include('plugins/ecommerce::deliveries.partials.delivery')
            @endif
            @include('plugins/ecommerce::deliveries.partials.order', ['order' => $order, 'delivery' => $delivery])
        </div>
        <div class="col-md-4 col-sm-12 right-sidebar d-flex flex-column-reverse flex-md-column">
            <div class="form-actions-wrapper">
                <div class="widget meta-boxes form-actions form-actions-default action-horizontal">
                    <div class="widget-title">
                        <h4>
                            <span>Publish</span>
                        </h4>
                    </div>
                    <div class="widget-body">
                        <div class="btn-set">
                            <button type="button" id="delivery_save_exit" value="save" class="btn btn-info">
                                <i class="fa fa-save"></i> Save &amp; Exit
                            </button>
                            &nbsp;
                            <button type="button" id="delivery_save" value="apply" class="btn btn-success">
                                <i class="fa fa-check-circle"></i> Save
                            </button>
                            &nbsp;
                            <button type="submit" name="submit" id="delivery_save_calendar" value="apply" class="btn btn-success">
                                <i class="fa fa-calendar"></i> Save & Calendar
                            </button>
                        </div>
                    </div>
                </div>
                <div id="waypoint"></div>
                <div class="form-actions form-actions-fixed-top hidden">
                    <ol class="breadcrumb" v-pre="">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/ecommerce/products">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/admin/ecommerce/deliveries">Delivery &amp; Pick Up</a></li>
                        <li class="breadcrumb-item active">Edit "Concrete Buggy - Daily"</li>
                    </ol>

                    <div class="btn-set">
                        <button type="submit" name="submit" value="save" class="btn btn-info">
                            <i class="fa fa-save"></i> Save &amp; Exit
                        </button>

                        &nbsp;
                        <button type="submit" name="submit" value="apply" class="btn btn-success">
                            <i class="fa fa-check-circle"></i> Save
                        </button>
                    </div>
                </div>
                <script>
                    $('button[name="submit"]').click(function(){
                        var currentval = $(this).val();
                        console.log($(this).val());
                        $( document ).ajaxComplete(function(e, xhr, settings) {
                            var url = settings.url
                            var splitUrl = url.split("/")
                            if(currentval == 'save'){
                                $('#botble-ecommerce-forms-global-option-form button[name="submit"]:nth-child(1)').trigger('click');
                                //$('form').submit();
                            }
                            if(currentval == 'apply'){
                                $('#botble-ecommerce-forms-global-option-form button[name="submit"]:nth-child(2)').trigger('click');
                                //$('form').submit();
                            }
                            if(currentval == 'save_as_new'){
                                $('#botble-ecommerce-forms-global-option-form button[name="submit"]:nth-child(3)').trigger('click');
                                //$('form').submit();
                            }
                            if(currentval == 'login'){
                                $('#botble-ecommerce-forms-global-option-form button[name="submit"]:nth-child(4)').trigger('click');
                                //$('form').submit();
                            }
                            console.log(splitUrl[5]);
                        });
                    })
                </script>
            </div>

            <div class="flexbox-layout-section-secondary" style="margin-top: 32px;">
                <div class="">
                    <div class="wrapper-content mb20">
                        <div class="next-card-section p-none-b">
                            <div class="flexbox-grid-default flexbox-align-items-center">
                                <div class="flexbox-auto-content-left">
                                    <label class="title-product-main text-no-bold">{{ trans('plugins/ecommerce::order.customer_label') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="next-card-section border-none-t">
                            <div class="mb5">
                                <strong class="text-capitalize">{{ $order->user->name ?: $order->address->name }}</strong>
                            </div>
                            @if ($order->user->id)
                                <div>
                                    <i class="fas fa-inbox mr5"></i><span>{{ $order->user->orders()->count() }}</span> {{ trans('plugins/ecommerce::order.orders') }}
                                </div>
                            @endif
                            <ul class="ws-nm text-infor-subdued">
                                <li class="overflow-ellipsis">
                                    <a class="hover-underline" href="mailto:{{ $order->user->email ?: $order->address->email }}">{{ $order->user->email ?: $order->address->email }}</a>
                                </li>
                                @if ($order->user->id)
                                    <li>
                                        <div>{{ trans('plugins/ecommerce::order.have_an_account_already') }}</div>
                                    </li>
                                @else
                                    <li>
                                        <div>{{ trans('plugins/ecommerce::order.dont_have_an_account_yet') }}</div>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        @if($order->shippingAddress->country || $order->shippingAddress->state || $order->shippingAddress->city || $order->shippingAddress->address || $order->shippingAddress->email || $order->shippingAddress->phone)
                            <div class="next-card-section">
                                @if (EcommerceHelper::countDigitalProducts($order->products) != $order->products->count())
                                    <div class="flexbox-grid-default flexbox-align-items-center">
                                        <div class="flexbox-auto-content-left">
                                            <label class="title-text-second"><strong>Billing Information</strong></label>
                                        </div>
                                        @if ($order->status != \Botble\Ecommerce\Enums\OrderStatusEnum::CANCELED)
                                            <div class="flexbox-auto-content-right text-end">
                                                <a href="#" class="btn-trigger-update-shipping-address">
                                                <span data-placement="top" data-bs-toggle="tooltip" data-bs-original-title="{{ trans('plugins/ecommerce::order.update_address') }}">
                                                    <svg class="svg-next-icon svg-next-icon-size-12">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 55.25 55.25"><path d="M52.618,2.631c-3.51-3.508-9.219-3.508-12.729,0L3.827,38.693C3.81,38.71,3.8,38.731,3.785,38.749  c-0.021,0.024-0.039,0.05-0.058,0.076c-0.053,0.074-0.094,0.153-0.125,0.239c-0.009,0.026-0.022,0.049-0.029,0.075  c-0.003,0.01-0.009,0.02-0.012,0.03l-3.535,14.85c-0.016,0.067-0.02,0.135-0.022,0.202C0.004,54.234,0,54.246,0,54.259  c0.001,0.114,0.026,0.225,0.065,0.332c0.009,0.025,0.019,0.047,0.03,0.071c0.049,0.107,0.11,0.21,0.196,0.296  c0.095,0.095,0.207,0.168,0.328,0.218c0.121,0.05,0.25,0.075,0.379,0.075c0.077,0,0.155-0.009,0.231-0.027l14.85-3.535  c0.027-0.006,0.051-0.021,0.077-0.03c0.034-0.011,0.066-0.024,0.099-0.039c0.072-0.033,0.139-0.074,0.201-0.123  c0.024-0.019,0.049-0.033,0.072-0.054c0.008-0.008,0.018-0.012,0.026-0.02l36.063-36.063C56.127,11.85,56.127,6.14,52.618,2.631z   M51.204,4.045c2.488,2.489,2.7,6.397,0.65,9.137l-9.787-9.787C44.808,1.345,48.716,1.557,51.204,4.045z M46.254,18.895l-9.9-9.9  l1.414-1.414l9.9,9.9L46.254,18.895z M4.961,50.288c-0.391-0.391-1.023-0.391-1.414,0L2.79,51.045l2.554-10.728l4.422-0.491  l-0.569,5.122c-0.004,0.038,0.01,0.073,0.01,0.11c0,0.038-0.014,0.072-0.01,0.11c0.004,0.033,0.021,0.06,0.028,0.092  c0.012,0.058,0.029,0.111,0.05,0.165c0.026,0.065,0.057,0.124,0.095,0.181c0.031,0.046,0.062,0.087,0.1,0.127  c0.048,0.051,0.1,0.094,0.157,0.134c0.045,0.031,0.088,0.06,0.138,0.084C9.831,45.982,9.9,46,9.972,46.017  c0.038,0.009,0.069,0.03,0.108,0.035c0.036,0.004,0.072,0.006,0.109,0.006c0,0,0.001,0,0.001,0c0,0,0.001,0,0.001,0h0.001  c0,0,0.001,0,0.001,0c0.036,0,0.073-0.002,0.109-0.006l5.122-0.569l-0.491,4.422L4.204,52.459l0.757-0.757  C5.351,51.312,5.351,50.679,4.961,50.288z M17.511,44.809L39.889,22.43c0.391-0.391,0.391-1.023,0-1.414s-1.023-0.391-1.414,0  L16.097,43.395l-4.773,0.53l0.53-4.773l22.38-22.378c0.391-0.391,0.391-1.023,0-1.414s-1.023-0.391-1.414,0L10.44,37.738  l-3.183,0.354L34.94,10.409l9.9,9.9L17.157,47.992L17.511,44.809z M49.082,16.067l-9.9-9.9l1.415-1.415l9.9,9.9L49.082,16.067z" /></svg>
                                                    </svg>
                                                </span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <ul class="ws-nm text-infor-subdued shipping-address-info">
                                            @include('plugins/ecommerce::orders.billing-address.detail', ['address' => $order->shippingAddress])
                                        </ul>
                                    </div>
                                @endif

                                @if (EcommerceHelper::isBillingAddressEnabled() && $order->billingAddress->id && $order->billingAddress->id != $order->shippingAddress->id)
                                    <div class="flexbox-grid-default flexbox-align-items-center">
                                        <div class="flexbox-auto-content-left">
                                            <label class="title-text-second"><strong>Delivery Information</strong></label>
                                        </div>
                                        <div class="flexbox-auto-content-right text-end">
                                            <a href="#" class="btn-trigger-update-billing-address">
                                                <span data-placement="top" data-bs-toggle="tooltip" data-bs-original-title="{{ trans('plugins/ecommerce::order.update_address') }}">
                                                    <svg class="svg-next-icon svg-next-icon-size-12">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 55.25 55.25"><path d="M52.618,2.631c-3.51-3.508-9.219-3.508-12.729,0L3.827,38.693C3.81,38.71,3.8,38.731,3.785,38.749  c-0.021,0.024-0.039,0.05-0.058,0.076c-0.053,0.074-0.094,0.153-0.125,0.239c-0.009,0.026-0.022,0.049-0.029,0.075  c-0.003,0.01-0.009,0.02-0.012,0.03l-3.535,14.85c-0.016,0.067-0.02,0.135-0.022,0.202C0.004,54.234,0,54.246,0,54.259  c0.001,0.114,0.026,0.225,0.065,0.332c0.009,0.025,0.019,0.047,0.03,0.071c0.049,0.107,0.11,0.21,0.196,0.296  c0.095,0.095,0.207,0.168,0.328,0.218c0.121,0.05,0.25,0.075,0.379,0.075c0.077,0,0.155-0.009,0.231-0.027l14.85-3.535  c0.027-0.006,0.051-0.021,0.077-0.03c0.034-0.011,0.066-0.024,0.099-0.039c0.072-0.033,0.139-0.074,0.201-0.123  c0.024-0.019,0.049-0.033,0.072-0.054c0.008-0.008,0.018-0.012,0.026-0.02l36.063-36.063C56.127,11.85,56.127,6.14,52.618,2.631z   M51.204,4.045c2.488,2.489,2.7,6.397,0.65,9.137l-9.787-9.787C44.808,1.345,48.716,1.557,51.204,4.045z M46.254,18.895l-9.9-9.9  l1.414-1.414l9.9,9.9L46.254,18.895z M4.961,50.288c-0.391-0.391-1.023-0.391-1.414,0L2.79,51.045l2.554-10.728l4.422-0.491  l-0.569,5.122c-0.004,0.038,0.01,0.073,0.01,0.11c0,0.038-0.014,0.072-0.01,0.11c0.004,0.033,0.021,0.06,0.028,0.092  c0.012,0.058,0.029,0.111,0.05,0.165c0.026,0.065,0.057,0.124,0.095,0.181c0.031,0.046,0.062,0.087,0.1,0.127  c0.048,0.051,0.1,0.094,0.157,0.134c0.045,0.031,0.088,0.06,0.138,0.084C9.831,45.982,9.9,46,9.972,46.017  c0.038,0.009,0.069,0.03,0.108,0.035c0.036,0.004,0.072,0.006,0.109,0.006c0,0,0.001,0,0.001,0c0,0,0.001,0,0.001,0h0.001  c0,0,0.001,0,0.001,0c0.036,0,0.073-0.002,0.109-0.006l5.122-0.569l-0.491,4.422L4.204,52.459l0.757-0.757  C5.351,51.312,5.351,50.679,4.961,50.288z M17.511,44.809L39.889,22.43c0.391-0.391,0.391-1.023,0-1.414s-1.023-0.391-1.414,0  L16.097,43.395l-4.773,0.53l0.53-4.773l22.38-22.378c0.391-0.391,0.391-1.023,0-1.414s-1.023-0.391-1.414,0L10.44,37.738  l-3.183,0.354L34.94,10.409l9.9,9.9L17.157,47.992L17.511,44.809z M49.082,16.067l-9.9-9.9l1.415-1.415l9.9,9.9L49.082,16.067z" /></svg>
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <ul class="ws-nm text-infor-subdued billing-address-info">
                                            @include('plugins/ecommerce::orders.billing-address.detail', ['address' => $order->billingAddress])
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endif
                        @if ($order->referral()->count())
                            <div class="next-card-section">
                                <div class="flexbox-grid-default flexbox-align-items-center mb-2">
                                    <div class="flexbox-auto-content-left">
                                        <label class="title-text-second"><strong>{{ trans('plugins/ecommerce::order.referral') }}</strong></label>
                                    </div>
                                </div>
                                <div>
                                    <ul class="ws-nm text-infor-subdued">
                                        @foreach (['ip',
                                            'landing_domain',
                                            'landing_page',
                                            'landing_params',
                                            'referral',
                                            'gclid',
                                            'fclid',
                                            'utm_source',
                                            'utm_campaign',
                                            'utm_medium',
                                            'utm_term',
                                            'utm_content',
                                            'referrer_url',
                                            'referrer_domain'] as $field)
                                            @if ($order->referral->{$field})
                                                <li>{{ trans('plugins/ecommerce::order.referral_data.' . $field) }}: <strong style="word-break: break-all">{{ $order->referral->{$field} }}</strong></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (is_plugin_active('marketplace') && $order->store->name)
                        <div class="wrapper-content bg-gray-white mb20">
                            <div class="pd-all-20">
                                <div class="p-b10">
                                    <strong>{{ trans('plugins/marketplace::store.store') }}</strong>
                                    <ul class="p-sm-r mb-0">
                                        <li class="ws-nm">
                                            <a href="{{ $order->store->url }}" class="ww-bw text-no-bold" target="_blank">{{ $order->store->name }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{--
                    <div class="wrapper-content bg-gray-white mb20">
                        <div class="pd-all-20">
                            <a href="{{ route('orders.reorder', ['order_id' => $order->id]) }}" class="btn btn-info">{{ trans('plugins/ecommerce::order.reorder') }}</a>&nbsp;
                            @if ($order->canBeCanceledByAdmin())
                                <a href="#" class="btn btn-secondary btn-trigger-cancel-order" data-target="{{ route('orders.cancel', $order->id) }}">{{ trans('plugins/ecommerce::order.cancel') }}</a>
                            @endif
                        </div>
                    </div>
                    --}}
                    <div style="margin-bottom:20px;">
                        @if($order->license_images)
                            <input type="hidden" name="alllicense_img" class="alllicense_img" value="{{$order->license_images}}" />
                            @php
                                $licenseimages = json_decode($order->license_images);
                                $i = 1;
                            @endphp
                            <div class="license_wrap" style="width:100%;">
                                @foreach($licenseimages as $licenseimg)
                                    <div class="actionLisense{{$i}} actionLisense">
                                        <img class="license_img{{$i}}" src="{{url('/')}}/storage/{{$licenseimg}}" style="width:300px; height:170px; padding-right:20px; cursor:pointer;" />

                                        <a href="{{url('/')}}/storage/{{$licenseimg}}" target="__blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <span class="deleteimg" data-id="{{$i}}" onclick="deleteLicense({{$i}})" ><i class="fa fa-trash" aria-hidden="true"></i></span>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </div>
                            <div style="clear:both"></div>
                        @endif
                    </div>
                    <x-core-setting::form-group>
                        <label class="text-title-field" for="admin-login-screen-backgrounds">Click to upload front/back license</label>
                        {!! Form::mediaImages('login_screen_backgrounds[]', is_array(setting('login_screen_backgrounds', '')) ? setting('login_screen_backgrounds', '') : json_decode(setting('login_screen_backgrounds', ''), true)) !!}
                    </x-core-setting::form-group>
                    <div class="mt10">
                        <button type="button" class="btn btn-primary btn-update-license">Save</button>
                        <div class="sucess_license" style="display:none;color:green;">License uploaded successfully.</div>
                        <div class="loader" style="display:none;"><img src="{{ url('/') }}/loader.gif" style="width:50px;" /></div>
                    </div>
                    <style>
                        .actionLisense{
                            width:300px;
                            text-align:center;
                            float:left;
                            margin-right:20px;
                            /* position:absolute;
                            margin-top:-100px;
                            text-align:center; */
                        }
                        .actionLisense a{
                            padding-right:20px;
                        }
                        /* .actionLisense:nth-of-type(2) {
                            margin-left:185px;
                        } */
                    </style>
                    <script>
                        function deleteLicense(id){

                            var selectedimg = $('.license_img'+id).attr('src');
                            var value = selectedimg.split("/");
                            if(typeof value[5] == 'undefined'){
                                var deletedimg = value[4]
                            }else{
                                var deletedimg = value[4]+'/'+value[5];
                            }

                            //console.log('deletedimg',deletedimg);
                            //return false;
                            var allimages = JSON.parse($('.alllicense_img').val());
                            var remainingarray = allimages.filter(function(item) {
                                return item !== deletedimg
                            })
                            $('.alllicense_img').val(JSON.stringify(remainingarray))
                            let orderid = $("input[name=order_id]").val();
                            let data = {}
                            data['orderid'] = orderid;
                            data['licenseimg'] = $('.alllicense_img').val();
                            $('.actionLisense'+id).hide();
                            //console.log(data);
                            //return false;

                            let url = "{{ route('orders.updatelicense') }}"
                            $.ajax({
                                type: "post",
                                url: url,
                                data: data,
                                beforeSend: function(){
                                    // Show image container
                                    //$('div.loader').show();
                                },
                                success: function (response) {
                                    console.log(response);

                                },
                                complete:function(data){
                                    // Hide image container
                                    //$("div.loader").hide();

                                    $(".sucess_license").show();

                                    // setTimeout(() => {
                                    //     window.location.reload(true);
                                    // }, 2000);



                                }
                            })

                        }
                        $(document).ready(function(){
                            // $(".license_img").hover(function(){
                            //     $(this).css('opacity','0.4');
                            //     $('.actionLisense').show();
                            // })
                            // $(".actionLisense").hover(function(){
                            //     $('.actionLisense').show();
                            // })

                            // $(".license_img").mouseout(function(){
                            //     $(this).css('opacity','1');
                            //     $('.actionLisense').hide();
                            // })

                            var imgArray = new Array();
                            $('.btn-update-license').click(function(){
                                if($('.alllicense_img').val()){
                                    var alllicense_img = JSON.parse($('.alllicense_img').val());
                                    $('.image-data').each(function(){
                                        imgArray.push($(this).val());

                                    });
                                    var allimg = imgArray.concat(alllicense_img);
                                } else {
                                    $('.image-data').each(function(){
                                        imgArray.push($(this).val());
                                    });
                                    var allimg = imgArray
                                }

                                let orderid = $("input[name=order_id]").val();

                                let data = {}
                                data['orderid'] = orderid;
                                data['licenseimg'] = JSON.stringify(allimg);

                                let url = "{{ route('orders.updatelicense') }}"
                                $.ajax({
                                    type: "post",
                                    url: url,
                                    data: data,
                                    beforeSend: function(){
                                        // Show image container
                                        $('div.loader', $('.btn-update-license').parent()).show();
                                    },
                                    success: function (response) {
                                        console.log(response);

                                    },
                                    complete:function(data){
                                        // Hide image container
                                        $("div.loader", $('.btn-update-license').parent()).hide();
                                        $(".sucess_license").show();
                                        setTimeout(() => {
                                            window.location.reload(true);
                                        }, 2000);



                                    }
                                })
                            })

                            $(document).on('click', '.btn-trigger-update-billing-address', event => {
                                event.preventDefault()
                                $('#update-billing-address-modal').modal('show')

                                $(document).on('click', '#confirm-update-billing-address-button', event => {
                                    event.preventDefault()
                                    let _self = $(event.currentTarget)

                                    _self.addClass('button-loading')

                                    $.ajax({
                                        type: 'POST',
                                        cache: false,
                                        url: _self.closest('.modal-content').find('form').prop('action'),
                                        data: _self.closest('.modal-content').find('form').serialize(),
                                        success: res => {
                                            if (!res.error) {
                                                Botble.showSuccess(res.message)
                                                $('#update-billing-address-modal').modal('hide')
                                                window.location.reload(true);

                                                let $formBody = $('.shipment-create-wrap')
                                                Botble.blockUI({
                                                    target: $formBody,
                                                    iconOnly: true,
                                                    overlayColor: 'none',
                                                })

                                                $('#select-billing-provider').load($('.btn-trigger-shipment').data('target') + '?view=true #select-shipping-provider > *', () => {
                                                    Botble.unblockUI($formBody)
                                                    Botble.initResources()
                                                })
                                            } else {
                                                Botble.showError(res.message)
                                            }
                                            _self.removeClass('button-loading')
                                        },
                                        error: res => {
                                            Botble.handleError(res)
                                            _self.removeClass('button-loading')
                                        },
                                    })
                                })


                            })
                        })
                    </script>
                </div>
            </div>

        </div>
    </div>

    @if ($order->status != \Botble\Ecommerce\Enums\OrderStatusEnum::CANCELED)
        <x-core-base::modal
            id="resend-order-confirmation-email-modal"
            :title="trans('plugins/ecommerce::order.resend_order_confirmation')"
            button-id="confirm-resend-confirmation-email-button"
            :button-label="trans('plugins/ecommerce::order.send')"
        >
            {!! trans('plugins/ecommerce::order.resend_order_confirmation_description', ['email' => $order->user->id ? $order->user->email : $order->address->email]) !!}
        </x-core-base::modal>

        <x-core-base::modal
            id="cancel-shipment-modal"
            :title="trans('plugins/ecommerce::order.cancel_shipping_confirmation')"
            button-id="confirm-cancel-shipment-button"
            :button-label="trans('plugins/ecommerce::order.confirm')"
        >
            {!! trans('plugins/ecommerce::order.cancel_shipping_confirmation_description') !!}
        </x-core-base::modal>

        <x-core-base::modal
            id="update-shipping-address-modal"
            :title="trans('plugins/ecommerce::order.update_address')"
            button-id="confirm-update-shipping-address-button"
            :button-label="trans('plugins/ecommerce::order.update')"
            size="md"
        >
            @include('plugins/ecommerce::orders.shipping-address.form', ['address' => $order->address, 'orderId' => $order->id, 'url' => route('orders.update-shipping-address', $order->address->id ?? 0)])
        </x-core-base::modal>


        <x-core-base::modal
            id="update-billing-address-modal"
            :title="trans('plugins/ecommerce::order.update_address')"
            button-id="confirm-update-billing-address-button"
            :button-label="trans('plugins/ecommerce::order.update')"
            size="md"
        >
            @include('plugins/ecommerce::orders.billing-address.form', ['address' => $order->billingAddress, 'orderId' => $order->id, 'url' => route('orders.update-billing-address', $order->billingAddress->id ?? 0)])
        </x-core-base::modal>

        <x-core-base::modal
            id="cancel-order-modal"
            :title="trans('plugins/ecommerce::order.cancel_order_confirmation')"
            button-id="confirm-cancel-order-button"
            :button-label="trans('plugins/ecommerce::order.cancel_order')"
        >
            {!! trans('plugins/ecommerce::order.cancel_order_confirmation_description') !!}
        </x-core-base::modal>

        @if (is_plugin_active('payment'))
            <x-core-base::modal
                id="confirm-payment-modal"
                :title="trans('plugins/ecommerce::order.confirm_payment')"
                button-id="confirm-payment-order-button"
                :button-label="trans('plugins/ecommerce::order.confirm_payment')"
            >
                {!! trans('plugins/ecommerce::order.confirm_payment_confirmation_description', ['method' => $order->payment->payment_channel->label()]) !!}
            </x-core-base::modal>

            <x-core-base::modal
                id="confirm-refund-modal"
                :title="trans('plugins/ecommerce::order.refund')"
                button-id="confirm-refund-payment-button"
                button-label="{{ trans('plugins/ecommerce::order.confirm_payment') }} <span class='refund-amount-text'>{{ format_price($order->payment->amount - $order->payment->refunded_amount) }}</span>"
            >
                @include('plugins/ecommerce::orders.refund.modal', ['order' => $order, 'url' => route('orders.refund', $order->id)])
            </x-core-base::modal>
        @endif
        @if ($order->shipment && $order->shipment->id)
            <x-core-base::modal
                id="update-shipping-status-modal"
                :title="trans('plugins/ecommerce::shipping.update_shipping_status')"
                button-id="confirm-update-shipping-status-button"
                :button-label="trans('plugins/ecommerce::order.update')"
                size="xs"
            >
                @include('plugins/ecommerce::orders.shipping-status-modal', ['shipment' => $order->shipment, 'url' => route('ecommerce.shipments.update-status', $order->shipment->id)])
            </x-core-base::modal>
        @endif
    @endif
@endsection
