@extends('plugins/ecommerce::orders.master')
@section('title')
    {{ __('Sign Terms. Order number :id', ['id' => $order->code]) }}
@stop

<style>
.gr-step-form{    width: 100%;
    max-width: 750px;
    margin: 0 auto;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;}
    .gr-form-heading{    text-align: center;
    margin-bottom: 15px;
    font-size: 22px;}
#gr-progress-bar {
    margin-bottom: 20px;text-align: center;
    overflow: hidden;
}
#gr-progress-bar li {
 color: #d8d8d8;margin-right: -5px;
        text-transform: capitalize;;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    min-width: 200px;
    display: inline-block;
    width: 33%;
    position: relative;
    padding-bottom: 15px;
}
#gr-progress-bar li i{    background: #d8d8d8;
    color: #fff;
    width: 40px;
    height: 40px;
    text-align: center;
    border-radius: 100%;
    vertical-align: middle;
    padding-top: 13px;    z-index: 1;
    position: relative;
    margin-bottom: 5px;}
#gr-progress-bar li.active i{    background: #36c6d3;}
#gr-progress-bar li span{display: block;}
#gr-progress-bar li:before {
    content: '';
    width: 100%;
    height: 2px;
    display: block;
    top: 20px;
    position: absolute;
    background: #d8d8d8;
    z-index: 0;
}
#gr-progress-bar li.active {
 color: #36c6d3;}
#gr-progress-bar li.active:before{
    background: #36c6d3;
    color: white;
}
.gr-step-form label{    font-weight: bold;}

.gr-step-form .gr-steps{

}
.gr-step-form .gr-steps .gr-btn-small{
       font-size: .75rem;
    padding: 4px 10px;
    background: #919191;
    border: none;
}
.gr-step-form .gr-btn-inline .btn{display: inline-block;}
.gr-step-form .gr-btn-inline .ui-select-wrapper{
    display: inline-block;
    width: calc(100% - 113px);
    vertical-align: middle;
    margin-right: 10px;
}
</style>

    <div class="container">
        @if($isadmin == '')
        @php
        $style = 'display:block;';
        @endphp
        @else
        @php
        $style = 'display:none;';
        @endphp
        @endif
        @if ($order->terms_signed != 1)

            <div class="row">
                <form id="customer-order-sign-form" class="form-inline" method="post" action="{{ route('public.checkout.sign-terms', $original_token) }}">
                    @csrf
                    <input type="hidden" name="customer_signature" id="customer_signature" value="">
                    <input type="hidden" name="signed_terms_html" id="signed_terms_html" value="">
                    <div class="col-12">
                        @include('plugins/ecommerce::orders.partials.logo')
                    </div>
                    <div class="term_orderid" style="display:none;">
                        <h3 style="color:red; text-align:center;margin-top: -29px;  margin-bottom: 21px;">Order ID #10000{{$order->id}}</h3>
                    </div>
                    <div class="col-12" id="terms_div">
                        <div style="text-align: center; margin: 50px auto; max-width: 800px; padding: 20px; border: 1px solid #ccc;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: bold;">Rent ‘n King Rental Agreement</h1>
                            <p style="margin: 10px 0; font-size: 16px;"><a href="http://www.RentnKing.com">www.RentnKing.com</a></p>
                            <p style="margin: 10px 0; font-size: 16px;">Development 360, Inc</p>
                        </div>

                        <ul id="gr-progress-bar">
                            <li class="active">
                                <i class="fa "></i> <span>Step 1</span>
                            </li>
                            <li class="active">
                                <i class="fa "></i> <span>Step 2</span>
                            </li>
                            <li>
                                <i class="fa "></i> <span>Step 3</span>
                            </li>
                        </ul>
                        <h4 style="text-align:center; margin-bottom:80px;">
                        <strong style="color:red; text-align:center; padding-bottom:20px; font-size:40px;">Your Order is almost complete but <br />we need you to complete this agreement form!</strong>
                        </h4>
                        {!! $finalTermHtml !!}
                        <div style="padding: 20px;">
                            <p style="margin: 0;">4385 SR-48, Charlotte, TN (615) 815-6734</p>
                            <p style="margin: 5px 0;">Rent ’n King is a Brand Name of Development 360, Inc</p>
                        </div>
                    </div>
                    <hr>
                    <div class="modal fade" id="signatureModal" tabindex="-1" role="dialog" aria-labelledby="signatureModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="signatureModalLabel">Signature Pad</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Place your signature pad HTML content here -->
                                    <div id="signature-pad">
                                        <div class="signature-pad--body">
                                            <canvas style="border: 1px solid #ccc;" id="signature-pad-canvas"></canvas>
                                        </div>
                                        <div class="signature-pad--footer">
                                            {{-- <div class="description">Sign above</div> --}}

                                            <div class="signature-pad--actions">
                                                <div class="column">
                                                    <button type="button" class="button clear" data-action="clear">Clear</button>
                                                    <button type="button" class="button" data-action="undo">Undo</button>
                                                </div>
                                                <div class="column" style="display: none;">
                                                    <button type="button" class="button" data-action="change-background-color">Change background color</button>
                                                    <button type="button" class="button" data-action="change-color">Change color</button>
                                                    <button type="button" class="button" data-action="change-width">Change width</button>
                                                </div>
                                                <div class="column" style="display: none;">
                                                    <button type="button" class="button save" data-action="save-png">Save as PNG</button>
                                                    <button type="button" class="button save" data-action="save-jpg">Save as JPG</button>
                                                    <button type="button" class="button save" data-action="save-svg">Save as SVG</button>
                                                    <button type="button" class="button save" data-action="save-svg-with-background">Save as SVG with background</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="padding-bottom: 10px;">
                        <button type="submit" id="submitButton1" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    @include('plugins/ecommerce::orders.partials.logo')
                </div>

                <div class="col-12" id="terms_div">
                    <div class="term_orderid" style="display:none;">
                        <h3 style="color:red; text-align:center;margin-top: -29px;  margin-bottom: 21px;">Order ID #10000{{$order->id}}</h3>
                    </div>
                {!! $order->signed_terms_html !!}
                </div>
            </div>
        @endif
    </div>

@section('script')
{!! Html::script('/themes/starbelly/plugins/jquery.min.js') !!}
<script src="https://szimek.github.io/signature_pad/js/signature_pad.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>



    @if ($order->terms_signed != 1)
        const wrapper = document.getElementById("signature-pad");
        const clearButton = wrapper.querySelector("[data-action=clear]");
        const changeBackgroundColorButton = wrapper.querySelector("[data-action=change-background-color]");
        const changeColorButton = wrapper.querySelector("[data-action=change-color]");
        const changeWidthButton = wrapper.querySelector("[data-action=change-width]");
        const undoButton = wrapper.querySelector("[data-action=undo]");
        const savePNGButton = wrapper.querySelector("[data-action=save-png]");
        const saveJPGButton = wrapper.querySelector("[data-action=save-jpg]");
        const saveSVGButton = wrapper.querySelector("[data-action=save-svg]");
        const saveSVGWithBackgroundButton = wrapper.querySelector("[data-action=save-svg-with-background]");
        const canvas = wrapper.querySelector("canvas");
        const signaturePad = new SignaturePad(canvas, {
            // It's Necessary to use an opaque color when saving image as JPEG;
            // this option can be omitted if only saving as PNG or SVG
            backgroundColor: 'rgb(255, 255, 255)',
        });

        // Adjust canvas coordinate space taking into account pixel ratio,
        // to make it look crisp on mobile devices.
        // This also causes canvas to be cleared.
        function resizeCanvas() {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            const ratio =  Math.max(window.devicePixelRatio || 1, 1);

            // This part causes the canvas to be cleared
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);

            // This library does not listen for canvas changes, so after the canvas is automatically
            // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
            // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
            // that the state of this library is consistent with visual state of the canvas, you
            // have to clear it manually.
            //signaturePad.clear();

            // If you want to keep the drawing on resize instead of clearing it you can reset the data.
            signaturePad.fromData(signaturePad.toData());
        }

        // On mobile devices it might make more sense to listen to orientation change,
        // rather than window resize events.
        window.onresize = resizeCanvas;
        resizeCanvas();

        clearButton.addEventListener("click", () => {
            signaturePad.clear();
        });

        function download(dataURL, filename) {
            const blob = dataURLToBlob(dataURL);
            const url = window.URL.createObjectURL(blob);

            const a = document.createElement("a");
            a.style = "display: none";
            a.href = url;
            a.download = filename;

            document.body.appendChild(a);
            a.click();

            window.URL.revokeObjectURL(url);
        }

        // One could simply use Canvas#toBlob method instead, but it's just to show
        // that it can be done using result of SignaturePad#toDataURL.
        function dataURLToBlob(dataURL) {
            // Code taken from https://github.com/ebidel/filer.js
            const parts = dataURL.split(';base64,');
            const contentType = parts[0].split(":")[1];
            const raw = window.atob(parts[1]);
            const rawLength = raw.length;
            const uInt8Array = new Uint8Array(rawLength);

            for (let i = 0; i < rawLength; ++i) {
                uInt8Array[i] = raw.charCodeAt(i);
            }

            return new Blob([uInt8Array], { type: contentType });
        }

        undoButton.addEventListener("click", () => {
            const data = signaturePad.toData();

            if (data) {
                data.pop(); // remove the last dot or line
                signaturePad.fromData(data);
            }
        });

        changeBackgroundColorButton.addEventListener("click", () => {
            const r = Math.round(Math.random() * 255);
            const g = Math.round(Math.random() * 255);
            const b = Math.round(Math.random() * 255);
            const color = "rgb(" + r + "," + g + "," + b +")";

            signaturePad.backgroundColor = color;
            const data = signaturePad.toData();
            signaturePad.clear();
            signaturePad.fromData(data);
        });

        changeColorButton.addEventListener("click", () => {
            const r = Math.round(Math.random() * 255);
            const g = Math.round(Math.random() * 255);
            const b = Math.round(Math.random() * 255);
            const color = "rgb(" + r + "," + g + "," + b +")";

            signaturePad.penColor = color;
        });

        changeWidthButton.addEventListener("click", () => {
            const min = Math.round(Math.random() * 100) / 10;
            const max = Math.round(Math.random() * 100) / 10;

            signaturePad.minWidth = Math.min(min, max);
            signaturePad.maxWidth = Math.max(min, max);
        });

        savePNGButton.addEventListener("click", () => {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
            } else {
                const dataURL = signaturePad.toDataURL();
                download(dataURL, "signature.png");
            }
        });

        saveJPGButton.addEventListener("click", () => {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
            } else {
                const dataURL = signaturePad.toDataURL("image/jpeg");
                download(dataURL, "signature.jpg");
            }
        });

        saveSVGButton.addEventListener("click", () => {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
            } else {
                const dataURL = signaturePad.toDataURL('image/svg+xml');
                download(dataURL, "signature.svg");
            }
        });

        saveSVGWithBackgroundButton.addEventListener("click", () => {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
            } else {
                const dataURL = signaturePad.toDataURL('image/svg+xml', {includeBackgroundColor: true});
                download(dataURL, "signature.svg");
            }
        });
    @endif

    $(document).ready(function() {
        $('#signatureModal').on('shown.bs.modal', function () {
            if (signaturePad.isEmpty()) {
                var modal = $('#signatureModal');
                var canvas = document.getElementById('signature-pad-canvas');
                var modalBody = modal.find('.modal-body');
                var modalWidth = 400;
                var modalHeight = 125;

                canvas.width = modalWidth;
                canvas.height = modalHeight;
                signaturePad.clear();
            }
        });

        $('#signatureModal').on('hidden.bs.modal', function () {
            if (!signaturePad.isEmpty()) {
                var imgSrc = signaturePad.toDataURL();
                var imgTag = '<img src="' + imgSrc + '" alt="Customer Signature" width="250" height="150"/>';
                $('.customer_signature_div').html(imgTag);
                $('.clear_sign').show();
                window.scrollTo(0, document.body.scrollHeight);
            }
        });
        const removebtn = document.getElementById("clear_sign");
        $(".clear_sign").click(function(){
            $('.customer_signature_div').empty();
            $('.customer_signature_div').append("<button type='button' class='btn btn-warning open-modal' data-toggle='modal' data-target='#signatureModal'>Sign Here</button>")
            $('.clear').trigger('click');
            $('.clear_sign').hide();
        })




        $('.customer_initials_checkbox').on('change', function() {
            var label = $(this).parent('label');
            if ($(this).is(':checked')) {
                label.find('span').text('Customer Approved');
                label.find('span').css('color', 'black');
            } else {
                label.find('span').text('Customer Approval Required');
                label.find('span').css('color', 'red');
            }
        });

        // $('body').on('click', '#submitButton', function () {
        // $('body').on('submit', '#customer-order-sign-form', function (e) {
        $('#customer-order-sign-form').submit(function(e) {
            // e.preventDefault();

            /* // custom validation disabled
            var allChecked = true;
            var uncheckedCheckbox = null;

            $("#customer-order-sign-form input[type='checkbox']").each(function() {
                if (!$(this).prop("checked")) {
                    allChecked = false;
                    uncheckedCheckbox = $(this);
                    return false;
                }
            });

            if (!allChecked) {
                alert("Please check all checkboxes before submitting.");

                // Scroll to the first unchecked checkbox
                if (uncheckedCheckbox) {
                    $('html, body').animate({
                        scrollTop: uncheckedCheckbox.offset().top - 100 // Adjust the offset as needed
                    }, 500);
                }

                return false;
            } */

            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
                e.preventDefault();
                return false;
            } else {
                $('#customer_signature').val(signaturePad.toDataURL());
            }
            $('#signed_terms_html').val($('#terms_div').html());

            // pdf code in progress
            // const contentDiv = document.getElementById("terms_div");
            // const pdf = new jsPDF();

            // // Convert the HTML content of the div to PDF
            // pdf.fromHTML(contentDiv, 15, 15, {
            //     width: 170
            // });
            // var output = pdf.output('datauristring');

            // $('#customer-order-sign-form').submit();
        });

        @if($order->terms_signed == 1)
            $("input[type='checkbox']").each(function() {
                $(this).prop("checked", true).attr('disabled', 'disabled');
            });
        @endif
    });

    $(document).ready(function(){
        const urlParams = new URLSearchParams(window.location.search);
        myParam = urlParams.get('admin');
        if(myParam == 'true'){
            $('#gr-progress-bar').hide();
            $('h4').hide();
        }

        const userParams = new URLSearchParams(window.location.search);
        myParam = userParams.get('user');
        if(myParam == 'true'){
            $('#gr-progress-bar').hide();
            $('h4').hide();
        }
        let orderid = $('.term_orderid').html()

        $(orderid).detach().insertBefore('ul:first')

        console.log('myParam',orderid);
    })

</script>
@stop
