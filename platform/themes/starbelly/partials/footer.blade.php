            <div id="alert-container"></div>
            @if(! empty(dynamic_sidebar('pre_footer_sidebar')))
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            {!! dynamic_sidebar('pre_footer_sidebar') !!}
                        </div>
                    </div>
                </div>
            @endif
            <footer>
                <div class="container">
                    <div class="sb-footer-frame">
                        <a href="{{ route('public.index') }}" class="sb-logo-frame">
                            @if (theme_option('logo'))
                                <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}">
                            @endif
                        </a>


                        <div class="col-lg-4 sb-copy" style="text-align:left;">
                            <b>Contact Information</b><br />
                            <a href="tel:6158156734"><i class="fa fa-phone" style="-webkit-transform: scaleX(-1);transform: scaleX(-1);"></i> (615) 815-6734 </a><br />
                            <i class="fa fa-map-marker" aria-hidden="false"></i> 10296 Highway 46, Bon Aqua, TN 37025<br />
                            <i class="fa fa-map-marker" aria-hidden="false"></i> 4385 SR-48, Charlotte, TN 37055 *Coming Soon!
                        </div>
                        <div class="col-lg-2 sb-copy" style="text-align:left;">
                            <a href="/privacy-policy"><b>Privacy and Policy</b></a>
                        </div>
                        @if($socialLinks = json_decode(theme_option('social_links')))
                            <ul class="sb-social">
                                @foreach($socialLinks as $social)
                                    @php($social = collect($social)->pluck('value', 'key'))
                                    <li>
                                        <a href="{{ $social->get('social-url') }}" title="{{ $social->get('social-name') }}"><i class="{{ $social->get('social-icon') }}"></i></a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="sb-copy">{!! BaseHelper::clean(theme_option('copyright')) !!}</div>
                    </div>
                </div>
            </footer>
        @if(Theme::has('footer'))
            {!! Theme::get('footer') !!}
        @endif
        <div class="sb-toast position-fixed end-0 p-3" style="z-index: 1111;">
            <div id="live-toast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="position-relative">
                    <div class="toast-body"></div>
                    <button type="button" class="btn-close position-absolute" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        {!! Theme::footer() !!}
        <script>
            window.siteConfig = {};

            @if (is_plugin_active('ecommerce') && EcommerceHelper::isCartEnabled())
                window.siteConfig.ajaxCart = "{{ route('public.ajax.cart') }}";
                window.siteConfig.cartUrl = "{{ route('public.cart') }}";
                window.siteConfig.wishlistUrl = "{{ route('public.wishlist') }}";
            @endif

            @if (session()->has('cartFlag') ==  true)
                $('.sb-minicart').toggleClass('sb-active');
            @endif
        </script>

        @if (session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
            <script type="text/javascript">
                window.noticeMessages = window.noticeMessages || [];
                @if (session()->has('success_msg'))
                window.noticeMessages.push({
                    message: '{{ session('success_msg') }}'
                });
                @endif

                @if (session()->has('error_msg'))
                window.noticeMessages.push({
                    type: 'error',
                    message: '{{ session('error_msg') }}'
                });
                @endif

                @if (isset($error_msg))
                window.noticeMessages.push({
                    type: 'error',
                    message: '{{ $error_msg }}'
                });
                @endif

                @if (isset($errors))
                @foreach ($errors->all() as $error)
                window.noticeMessages.push({
                    type: 'error',
                    message: '{!! BaseHelper::clean($error) !!}'
                });
                @endforeach
                @endif
            </script>
        @endif

        <script>
            $(document).ready(function() {
                $('.rental_option_swal').on('click', function() {
                    var checkName = $(this).val();
                    if (!$(this).prop('checked')) {
                        // Check if the checkbox is unchecked
                        const comment = $(this).data('comment');
                        const formattedComment = comment.split('\n').join('<br>');

                        // Swal.fire(comment);
                        Swal.fire({
                            // title: 'Do you want to save the changes?',
                            html: formattedComment, // Use "html" instead of "text" to render HTML tags
                            // width: 600,

                            showDenyButton: true,
                            denyButtonText: "No Thanks, I'll Take The Risk",
                            denyButtonColor: '#CC3333',
                            confirmButtonText: 'Keep '+checkName,
                            confirmButtonColor: 'green',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $(this).prop('checked', true);
                            } else if (result.isDenied) {
                                $(this).prop('checked', false);
                            }
                        });
                    }
                });
            });
        </script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <style>
    div:where(.swal2-container) div:where(.swal2-actions){
        flex-direction: row-reverse !important;
    }
    div:where(.swal2-container) .swal2-html-container{
        text-align:left !important;
    }
    .ui-datepicker-trigger{
        background-color: #fff;
    font-size: 29px;
    border: none;
    padding: 7px;
    /* right: 288px; */
    position: absolute;
    margin-top: -54px;
    width: 55px;
    height: 54px;
    color:#fff;
}

    .fa-calendar{
        color:#fff;
    }
    #datepicker{
        pointer-events: none;
    }
    .ui-widget.ui-widget-content{
        margin-top:-44px;
    }
  </style>
            <script>
        jQuery(function($){ // wait until the DOM is ready
            //$(".datepicker1").datepicker();
            $("#datepicker").datepicker({
                showOn: 'button',
                minDate: 0,
                buttonText: "",
            }).next('button').prepend('<img src="https://rentnking.com/calendar_icon.png" style="width:52px;" />');
            //$("#datepicker").datepicker({ dateFormat: "yy-mm-dd" });
            $("#datepicker").change(function(){
                if($("#datepicker").val() != 'Select Date'){
                    $(".errordate").hide();
                    $("#datepicker").css('color','#231e41');
                }
            })
            $(".sb-atc").click(function(){
                let store = !$('#store_id').val() && $('#store_pickup').prop('checked') == true;
                if (store) {
                    $("#store_id").css('border-color','red');
                }else{
                    $("#store_id").css('border-color','#212529');
                }
                let selecteddate = $("#datepicker").val();
                if(selecteddate == 'Select Date'){
                    $("#datepicker").css('color','red');
                }else{
                    $(".errordate").hide();
                }
                let selection = $("#delivery").prop('checked') || $("#store_pickup").prop('checked');
                if (selection == true) {
                    $("#delivery").parent().css('color', '#212529')
                    $("#store_pickup").parent().css('color','#212529');
                } else {
                    $("#delivery").parent().css('color', 'red')
                    $("#store_pickup").parent().css('color','red');
                }

                if (selecteddate == 'Select Date' || store || selection == false) {
                    return false;
                }

                setTimeout(() => {
                    $('.sb-btn-cart').trigger('click');
                }, 1000);

            })


        });
    </script>
    </body>
</html>
