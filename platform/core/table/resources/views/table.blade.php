@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    @include('core/table::base-table')
@stop



@if (\Request::segment(3) == 'company')
@section('javascript')
<script>
    $(document).ready(function(){
        $(document).on('click', '.custome-email-template-create', function(e) {
                e.preventDefault();
                $('#exampleModal').modal('show');
            });

            $(document).on('click', '.companyCreateBtn', function (e) {
                e.preventDefault();
                var company_name = $('#company_name').val();
                if (company_name != '') {
                $('#emailHelp').html('');
                $companyid = $('#company_id').val();
                var url = window.location.origin + '/admin/contacts/company/create';
                var data = {
                    'company_name': $('#company_name').val(),
                    'company_email': $('#company_email').val(),
                    'company_country': $('#company_country').val(),
                    'company_url': $('#company_url').val(),
                    'company_address': $('#company_address').val(),
                    'company_id':$('#company_id').val()
                };
                $.ajax({
                    type: "get",
                    url: url,
                    data: data,
                    success: function success(response) {
                    console.log(response);
                    if (response.status == true) {
                        if($companyid){
                            toastr.success('Company Data Updated Successfully');
                        }else{
                            toastr.success('Company Data Added Successfully');
                        }

                        setTimeout(() => {
                            window.location.reload(true);
                        }, 2000);

                    } else {
                        toastr.error(response.message);
                    }
                    }
                });
                } else {
                $('#emailHelp').html('Please Enter Company Name');
                }
            });

            $(document).on('click', '.editcompany', function(e) {

                let id = $(this).attr('data-id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var formData = {
                    id: id,
                };
                var ajaxurl = 'editcompany';
                var type = "POST";
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        //console.log('data',data);
                        $('#company_name').val(data.company_name);
                        $('#company_email').val(data.company_email);
                        $('#company_url').val(data.company_url);
                        $('#company_address').val(data.company_address);
                        $('#company_id').val(data.id);

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
                $('#exampleModal').modal('show');
            });

    })
$('.table-wrapper').after(`
 <div class="row">
                <div id="exampleModal" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>Add Company</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close"></button></div> <div class="modal-body with-padding">
                <div class="row p-2">
                    <form action="#" id="companyCreateForm">
                    <input type="hidden" id="company_id" value="" />
                        <div class="mb-3 col-md-3" style="float:left;margin-right:15px;">
                            <label for="company_name" class="form-label required">Company Name</label>
                            <input type="text" class="form-control" id="company_name" aria-describedby="emailHelp" name="company_name"/>
                            <small id="emailHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="mb-3 col-md-3" style="float:left;margin-right:15px;">
                            <label for="company_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="company_email" aria-describedby="emailHelp" name="company_email"/>
                        </div>
                        <div class="mb-3 col-md-3" style="float:left;margin-right:15px;">
                        <label for="company_country" class="form-label">Country</label>
                        <select id="company_country" class="form-select form-control" aria-label="Default select example" name="company_country">
                                <option value="United State">United State</option>
                                </select>
                        </div>
                        </div>
                        <div class="row">
                        <div class="mb-3 col-md-3" style="float:left;margin-right:15px;">
                            <label for="company_url" class="form-label">URL</label>
                            <input type="email" class="form-control" id="company_url" aria-describedby="emailHelp" name="company_url">
                        </div>

                        <div class="mb-3 col-md-6" style="float:left;margin-right:15px;">
                            <label for="company_address">Address</label>
                            <textarea class="form-control" placeholder="Address" id="company_address" style="height: 100px" name="company_address"></textarea>
                        </div>
                        </div>


                 </div>
                     <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="float-start btn btn-warning">Cancel</button>
                     <button type="button" class="btn btn-primary companyCreateBtn">save</button>
                     </form></div></div></div></div></div>   `)
</script>
@endsection
@endif

@if (\Request::segment(2) == 'smslogs')
@section('javascript')
<script>

$(document).ready(function(){
    $(document).on('click', '.sendMailToNewsLatterMail', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                setTimeout(() => {
                    $(this).hide();
                }, 1000);

                console.log('id',id);
                //return false;
                let data = {}
                data['id'] = id;
                let url = "{{ route('updatesmsstatus') }}"
                    $.ajax({
                        type: "post",
                        url: url,
                        data: data,
                        beforeSend: function(){
                        // Show image container
                        $(this).find('a div.loader').show();
                    },
                        success: function (response) {
                            console.log(response);
                            $(this).html("confirmed")

                            $(this).addClass("confirmed")
                        },
                        complete:function(data){
                        // Hide image container
                        $(".loader",this).hide();
                        window.location.reload(true);

                    }
                    });
            });
})
</script>
@endsection
@endif

@if (\Request::segment(2) == 'newsletters')
    @section('javascript')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>
                $(document).ready(function(){
                    $(".contactTags").select2({
                                    tags: true
                                });


                })

                $(document).ready(function(){
                    $(".contactTags2").select2({
                                    tags: true
                                });


                })

                                </script>
        <script>
            $('.table-wrapper').after(`
            <div class="row">
                <div id="exampleModal" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>Create Newsletter</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close"></button></div> <div class="modal-body with-padding">

                            <form action="#" id="newsLetterCreateForm" class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label required">Template Name</label>
                                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name"/>
                                    <small id="emailHelp" class="form-text text-muted nameValidationError"></small>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="subject" class="form-label required">Template Subject</label>
                                    <input type="text" class="form-control" id="subject" aria-describedby="emailHelp" name="subject"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" placeholder="Template Description" id="description" style="height: 100px" name="description"></textarea>
                                </div>
                                <div class="row"><div class="col-2"></div></div>


                     <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="float-start btn btn-warning">Cancel</button> <button type="button" class="btn btn-primary newsLetterCreateBtn">save</button></div></form></div></div></div></div>
            `);

            $('.table-wrapper').after(`

            <div class="row">
            <div id="ecomment-modal1" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>Email Brodcast</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close"></button></div> <div class="modal-body with-padding">
            <div class="row p-2">
                            <div class="mb-2" style="background:linear-gradient(to top, rgba(229,229,229,1) 0%,rgba(255,255,255,0) 100%) bottom,linear-gradient(to top, rgba(229,229,229,1) 0%,rgba(255,255,255,0) 100%) top;">
                            <p class="p-2 pb-0">Please select below option to send Email</p>
                            </div>

                        </div>
                            <form action="#" id="newsLetterSendmailForm" class="" style="text-align:center;">
                                <input type="hidden" name="email_template_id" id="email_template_id"/>
                                <div class="form-check form-check-inline m-2">
                                    <label class="form-check-label" for="inlineCheckbox1">Select All</label>
                                    <input class="form-check-input"  type="checkbox" id="inlineCheckbox1" value="all" name="newsletter_mail_receivers">


                                </div>
                                <div class="form-check form-check-inline m-2 contactTagsd">
                                <label>Select Tag </label>
                                <select class="form-control contactTags" name="contactTag[]" style="width:200px;border:1px solid rgba(0,0,0,.25) !important;" multiple="multiple">

                                </select>


                                </div>
                                <div class="text-danger newsletter-mail-error"></div>
                                </div>
                            </form>

                 <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="float-start btn btn-warning">Cancel</button> <button id="save-comment-button" class="float-end btn btn-info newsLetterMailsendBtn" type="button">submit</button></div></div></div></div></div>
            `);


            $(document).on('click', '.custome-email-template-create', function(e) {
                e.preventDefault();
                $('#exampleModal').modal('show');
            });

            $(document).on('click','#inlineCheckbox1',function(){
                if($("#inlineCheckbox1").prop('checked') == true){
                    $('.contactTagsd ').hide();
                }else{
                    $('.contactTagsd ').show();
                }
            })

            $(document).on('click', '.sendMailToNewsLatterMail', function(e) {
                e.preventDefault();

                let id = $(this).attr('data-id');
                $('#email_template_id').val(id);
                var url = 'http://rentnking.com/api/contacttags';
                $.ajax({
                        type: "get",
                        url: url,
                        success: function (response) {
                            if(response){
                                var html = '';
                                var resjson = JSON.parse(response)
                                resjson.forEach(function(data) {
                                console.log(data.name);
                                html += '<option value="'+data.name+'">'+data.name+'</option>';
                               })
                                $(".contactTags").html(html);
                            }

                            if(response.status == true){
                                $('#ecomment-modal1').modal('hide');
                                toastr.success(response.message);
                            }
                        }
                    });
                $('#ecomment-modal1').modal('show');
            });


            $(document).on('click', '.newsLetterMailsendBtn', function(e) {

                e.preventDefault();
                let val = [];
                $("input:checkbox[name=newsletter_mail_receivers]:checked").each(function() {
                    val.push($(this).val());
                });



                    let data = {};

                    data['receivers_roles'] = val;
                    data['tagged_contacts'] = $('.contactTags').val();
                    data['email_template_id'] = $('#email_template_id').val();

                    let url = "{{ route('newsletter.bulk.send') }}"
                    $.ajax({
                        type: "get",
                        url: url,
                        data: data,
                        success: function (response) {
                            console.log(response);
                            if(response.status == true){
                                $('#ecomment-modal1').modal('hide');
                                toastr.success(response.message);
                            }
                        }
                    });

                //}
            });
            $(document).on('click', '.newsLetterCreateBtn', function(e) {
                e.preventDefault();
                if ($("#newsLetterCreateForm").valid() == true) {


                    let url = "{{ route('newsletter.emailtemplate.create') }}";
                    let data = {};
                    data['name'] = $('#name').val();
                    data['subject'] = $('#subject').val();
                    data['description'] = $('#description').val();

                    $.ajax({
                        type: "get",
                        url: url,
                        data: data,
                        success: function(response) {
                            if (response.message == 'Error : Validation Error') {
                                console.log(response.data.name);
                                let namevalidationerror = response.data.name;
                                $('.nameValidationError').html(namevalidationerror);
                            } else if (response.slug != undefined) {
                                $('.nameValidationError').html('');
                                let url = window.location.origin +
                                    "/admin/settings/email/templates/edit/plugins/newsletter/" + response
                                    .slug + "?is_template=1";
                                window.location = url;
                            }
                        }
                    });


                }

            });
            // this is for validation and message
            $("#newsLetterCreateForm").validate({
                errorClass: 'is-invalid',
                rules: {
                    name: {
                        required: true,
                    },
                    subject: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "Please enter Template name",
                    },
                    subject: {
                        required: "Please enter Subject",
                    },
                },
            });

            $(document).on('click', '.copymail', function(e) {
                console.log('hi');

                let url = "{{ route('copymail') }}";
                let data = {};
                data['id'] = $(this).attr('data-id');


                $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    success: function(response) {
                        window.location.reload(true);
                    }
                });
            });

        </script>
    @endsection
@endif

@if (\Request::segment(2) == 'smsbrodcast')
    @section('javascript')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>
                $(document).ready(function(){
                    $(".contactTags").select2({
                                    tags: true
                                });


                })

                $(document).ready(function(){
                    $(".contactTags2").select2({
                                    tags: true
                                });


                })
        </script>
        <script>
            $('.table-wrapper').after(`
            <div class="row">
                <!-- Modal -->
                <div id="comment-modal" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>SMS Brodcast</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close"></button></div> <div class="modal-body with-padding">
                <label for="comment-text">Title</label>
                <input type="text" name="comment-text"  class="form-control sms_name" />
                <label for="comment-text">Description</label>
                <textarea name="comment-text" maxlength="150" id="comment-text" rows="4" class="form-control smsbody"></textarea>
                <em style="text-align:right;"><span class="type_char1">0</span>/150</em><br />
                <span class="error" style="color:red"></span>
                <br /><span class="sucess" style="color:green"></span>
                </div> <div class="modal-footer"><div><button type="button" data-bs-dismiss="modal" class="float-start btn btn-warning">Cancel</button> <button id="save-comment-button" class="float-end btn btn-info " type="button">submit</button></div>

                </div>

                </div></div></div>`);


                $('.table-wrapper').after(`
            <div class="row">
                <!-- Modal -->

                <div id="comment-modal2" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>SMS Brodcast</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close"></button></div> <div class="modal-body with-padding">
                <form name="updatesms" id="updatesmsform"  method="POST" action="https://rentnking.com/admin/updatesms" >
                <label for="comment-text">Title</label>

                <input type="hidden" name="sms_id" id="sms_id" value="" />
                <input type="text" name="sms_title" required  class="form-control sms_title" />
                <label for="comment-text">Description</label>
                <textarea name="sms_description" required id="comment-text" rows="4" maxlength="150" class="form-control sms_description"></textarea>
                <em style="text-align:right;"><span class="type_char">0</span>/150</em><br />
                <span class="error" style="color:red"></span>
                 <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="float-start btn btn-warning">Cancel</button> <button id="save-comment-button1" class="float-end btn btn-info updatesms " type="submit">submit</button></div></div></div></form></div>`);

                $('.table-wrapper').after(`
            <div class="row">
            <div id="comment-modal1" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>SMS Brodcast</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close"></button></div> <div class="modal-body with-padding">
            <div class="row p-2">
                            <div class="mb-2" style="background:linear-gradient(to top, rgba(229,229,229,1) 0%,rgba(255,255,255,0) 100%) bottom,linear-gradient(to top, rgba(229,229,229,1) 0%,rgba(255,255,255,0) 100%) top;">
                            <p class="p-2 pb-0">Please select below option to send SMS Directly</p>
                            </div>

                        </div>
            <form action="#" id="newsLetterSendmailForm" style="text-align:center;" class="">
                                <input type="hidden" name="email_template_id" id="email_template_id"/>
                                <div class="form-check form-check-inline m-2">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="all" name="newsletter_mail_receivers">
                                    <label class="form-check-label" for="inlineCheckbox1">Select All</label>
                                </div>
                                <div class="form-check form-check-inline m-2 contactTagsd">
                                <label>Select Tag </label>
                                <select class="form-control contactTags2" name="contactTag[]" style="width:200px;" multiple="multiple">

                                </select>


                                </div>
                                <div class="text-danger newsletter-mail-error"></div>
                                </div>
                            </form>

                 <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="float-start btn btn-warning">Cancel</button> <button id="save-comment-button" class="float-end btn btn-info smssendBtn" type="button">submit</button></div></div></div></div></div>

            `);

            $('.sms_description').keyup(function () {
                var len = $(this).val().length;
                $('.type_char').text(len);
            });

            $('.smsbody').keyup(function () {
                var len = $(this).val().length;
                $('.type_char1').text(len);
            });

            $(document).on('click','#inlineCheckbox1',function(){
                if($("#inlineCheckbox1").prop('checked') == true){
                    $('.contactTagsd ').hide();
                }else{
                    $('.contactTagsd ').show();
                }
            })
            $(document).on('click', '.custome-email-template-create', function(e) {
                e.preventDefault();
                $('#comment-modal').modal('show');
            });

            $(document).on('click','#save-comment-button',function(){
                let sms_name = $('.sms_name').val();
                let sms_description = $('.smsbody').val();
                if(sms_name == ''){
                    $('.error').html('Please provide SMS Name')
                    return false;
                }
                if(sms_description == ''){
                    $('.error').html('Please provide SMS Description')
                    return false;
                }
                let url = "{{ route('smsbrodcast.create') }}";
                let data = {};
                data['sms_title'] =  $('.sms_name').val();
                data['smstdescription'] = $('.smsbody').val();
                $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    beforeSend: function() {
                        $('.error').html('')
                    },
                    success: function(response) {
                        $('.sucess').html('<b>'+response.message+'</b>')
                        console.log('response',response.message);

                        // window.location.replace(
                        //     "{{route('smsbrodcast.process')}}"
                        //     );
                       //
                       setTimeout(() => {
                        window.location.reload(true);
                       }, 2000);

                    }
                });


            })

            $('form').append('{{csrf_field()}}');
            $(".updatesms").click(function(){
                let sms_name = $('.sms_title').val();
                let sms_description = $('.sms_description').val();
                if(sms_name && sms_description){
                    $('.error').html('')
                }
                if(sms_name == ''){
                    $('.error').html('Please provide SMS Name')
                    return false;
                }
                if(sms_description == ''){
                    $('.error').html('Please provide SMS Description')
                    return false;
                }
                $("#updatesmsform").submit(); // Submit the form
            });
            $(document).on('click', '.copysms', function(e) {
                console.log('hi');

                let url = "{{ route('copysms') }}";
                let data = {};
                data['id'] = $(this).attr('data-id');


                $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    success: function(response) {
                        alert("SMS Copy Successfully")
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 1000);

                    }
                });
            });


            $(document).on('click', '.editsms', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                console.log('id',id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var formData = {
                    id: id,
                };
                var ajaxurl = 'editsms';
                var type = "POST";
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        //console.log('data',data);
                        $('.sms_title').val(data.name);
                        $('.sms_description').val(data.description);
                        $('#sms_id').val(data.id);
                        var len = $('.sms_description').val().length;
                        $('.type_char').text(len);


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

                $('#email_template_id').val(id);
                $('#comment-modal2').modal('show');
            });

            $(document).on('click', '.sendMailToNewsLatterMail', function(e) {
                e.preventDefault();

                let id = $(this).attr('data-id');
                $('#email_template_id').val(id);
                var url = 'http://rentnking.com/api/contacttags';
                $.ajax({
                        type: "get",
                        url: url,
                        success: function (response) {
                            if(response){
                                var resjson = JSON.parse(response)
                                resjson.forEach(function(data) {
                                console.log(data.name);
                                var html = '<option value="'+data.name+'">'+data.name+'</option>';
                                $(".contactTags2").append(html);
                                })
                            }

                            if(response.status == true){
                                $('#ecomment-modal1').modal('hide');
                                toastr.success(response.message);
                            }
                        }
                    });
                $('#ecomment-modal1').modal('show');

            });
            $(document).on('click', '.newsLetterMailsendBtn', function(e) {

                e.preventDefault();
                let val = [];
                $("input:checkbox[name=newsletter_mail_receivers]:checked").each(function() {
                    val.push($(this).val());
                });



                    let data = {};
                    data['receivers_roles'] = val;
                    data['email_template_id'] = $('#email_template_id').val();

                    let url = "{{ route('newsletter.bulk.send') }}"
                    $.ajax({
                        type: "get",
                        url: url,
                        data: data,
                        success: function (response) {
                            console.log(response);
                            if(response.status == true){
                                $('#exampleModal1').modal('hide');
                                toastr.success(response.message);
                            }
                        }
                    });


            });

            $(document).on('click', '.sendMailToNewsLatterMail', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                $('#email_template_id').val(id);
                $('#comment-modal1').modal('show');
            });
            $(document).on('click', '.smssendBtn', function(e) {

                e.preventDefault();
                let val = [];
                $("input:checkbox[name=newsletter_mail_receivers]:checked").each(function() {
                    val.push($(this).val());
                });



                    let data = {};
                    data['receivers_roles'] = val;
                    data['tagged_contacts'] = $('.contactTags2').val();
                    data['email_template_id'] = $('#email_template_id').val();

                    let url = "{{ route('sms.bulk.send') }}"
                    $.ajax({
                        type: "get",
                        url: url,
                        data: data,
                        success: function (response) {
                            console.log(response);
                            if(response.status == true){
                                $('#comment-modal1').modal('hide');
                                toastr.success(response.message);
                            }
                        }
                    });


            });


            $(document).on('click', '.newsLetterCreateBtn', function(e) {
                e.preventDefault();
                if ($("#newsLetterCreateForm").valid() == true) {


                    let url = "{{ route('newsletter.emailtemplate.create') }}";
                    let data = {};
                    data['name'] = $('#name').val();
                    data['subject'] = $('#subject').val();
                    data['description'] = $('#description').val();

                    $.ajax({
                        type: "get",
                        url: url,
                        data: data,
                        success: function(response) {
                            if (response.message == 'Error : Validation Error') {
                                console.log(response.data.name);
                                let namevalidationerror = response.data.name;
                                $('.nameValidationError').html(namevalidationerror);
                            } else if (response.slug != undefined) {
                                $('.nameValidationError').html('');
                                let url = window.location.origin +
                                    "/admin/settings/email/templates/edit/plugins/newsletter/" + response
                                    .slug + "?is_template=1";
                                window.location = url;
                            }
                        }
                    });


                }

            });
            // this is for validation and message
            $("#newsLetterCreateForm").validate({
                errorClass: 'is-invalid',
                rules: {
                    name: {
                        required: true,
                    },
                    subject: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "Please enter Template name",
                    },
                    subject: {
                        required: "Please enter Subject",
                    },
                },
            });
        </script>
    @endsection
@endif


@if (Request::segment(3) == 'contacttags' || Request::segment(3) == 'create')


    @section('javascript')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $('.table-wrapper').after(`
            <div class="row">
                <!-- Modal -->
                <div id="comment-modal" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>Contact Tags</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close"></button></div> <div class="modal-body with-padding">
                <form name="updatesms" id="createtagform" method="POST" action="https://rentnking.com/admin/contacts/createtags" >
                <label for="comment-text">Title</label>
                <input type="text" name="tagtitle"  class="form-control" />
                <span class="error" style="color:red"></span>

                </div> <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="float-start btn btn-warning cancelbtnc">Cancel</button> <button id="save-comment-button" class="float-end btn btn-info createtags " type="button">submit</button></form></div></div></div></div>`);


                $('.table-wrapper').after(`
            <div class="row">
                <!-- Modal -->

                <div id="comment-modal2" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>Contact Tag</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close"></button></div> <div class="modal-body with-padding">
                <form name="updatetag" id="updatetagform" method="POST" action="https://rentnking.com/admin/contacts/updatetag" >
                <label for="comment-text">Title</label>

                <input type="hidden" name="sms_id" id="sms_id" value="" />
                <input type="text" name="sms_title"  class="form-control sms_title" />
                <span class="error" style="color:red"></span>
                 <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="float-start btn btn-warning cancelbtnu">Cancel</button> <button id="save-comment-button" class="float-end btn btn-info updatetag " type="submit">submit</button></div></div></div></form></div>`);

                $('.table-wrapper').after(`
            <div class="row">
            <div id="comment-modal1" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>SMS Brodcast</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close"></button></div> <div class="modal-body with-padding">
            <div class="row p-2">
                            <div class="mb-2" style="background:linear-gradient(to top, rgba(229,229,229,1) 0%,rgba(255,255,255,0) 100%) bottom,linear-gradient(to top, rgba(229,229,229,1) 0%,rgba(255,255,255,0) 100%) top;">
                            <p class="p-2 pb-0">Please select below option to send SMS Directly</p>
                            </div>

                        </div>
            <form action="#" id="newsLetterSendmailForm" class="">
                                <input type="hidden" name="email_template_id" id="email_template_id"/>
                                <div class="form-check form-check-inline m-2">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" checked value="customers" name="newsletter_mail_receivers">
                                    <label class="form-check-label" for="inlineCheckbox1">Customers</label>
                                </div>
                                <div class="form-check form-check-inline m-2">
                                    <input class="form-check-input" type="checkbox" checked id="inlineCheckbox2" value="contacts" name="newsletter_mail_receivers">
                                    <label class="form-check-label" for="inlineCheckbox2">Contacts</label>
                                </div>
                                <div class="text-danger newsletter-mail-error"></div>
                                </div>
                            </form>

                 <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="float-start btn btn-warning">Cancel</button> <button id="save-comment-button" class="float-end btn btn-info smssendBtn" type="button">submit</button></div></div></div></div></div>

            `);



            $(document).on('click', '.custome-email-template-create', function(e) {
                e.preventDefault();
                $('#comment-modal').modal('show');
            });
            $('form').append('{{csrf_field()}}');
            $(".updatetag").click(function(){
                let tagt = $("input[name=sms_title]").val();
                if(tagt == ''){
                    $('.error').html("this field is required.");
                    return false;
                }else{
                    $("#updatetagform").submit(); // Submit the form
                }

            });

            $('.cancelbtnc').click(function(){
                $('#createtagform')[0].reset();
                $('.error').html("");
            })
            $('.cancelbtnu').click(function(){
                $('#updatetagform')[0].reset();
                $('.error').html("");
            })

            $(".createtags").click(function(){
                let tag = $("input[name=tagtitle]").val();
                let url = "{{ route('contacttags.checkduplicate') }}"
                let data = {}
                data['name'] = tag;
                if(tag == ''){
                    $('.error').html("this field is required.");
                }else{
                    $('.error').html("");
                    $.ajax({
                    type: "post",
                    url: url,
                    data: data,

                    success: function(response) {
                        console.log(response)
                        if(response > 0){
                            $('.error').html("This tag already exsit.");
                            return false

                        }else{
                            $("#createtagform").submit(); // Submit the form
                        }
                        //
                    }
                });

                }

            });
            $(document).on('click', '.copysms', function(e) {
                console.log('hi');

                let url = "{{ route('copysms') }}";
                let data = {};
                data['id'] = $(this).attr('data-id');


                $.ajax({
                    type: "post",
                    url: url,
                    data: data,

                    success: function(response) {
                        window.location.reload(true);
                    }
                });
            });


            $(document).on('click', '.edittag', function(e) {

                let id = $(this).attr('data-id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var formData = {
                    id: id,
                };
                var ajaxurl = 'edittag';
                var type = "POST";
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        //console.log('data',data);
                        $('.sms_title').val(data.name);

                        $('#sms_id').val(data.id);



                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

                $('#email_template_id').val(id);
                $('#comment-modal2').modal('show');
            });


            $(document).on('click', '.newsLetterMailsendBtn', function(e) {

                e.preventDefault();
                let val = [];
                $("input:checkbox[name=newsletter_mail_receivers]:checked").each(function() {
                    val.push($(this).val());
                });

                if(val.length == 0){
                    $('.newsletter-mail-error').html('* please select Atleast one option');
                }else{
                    $('.newsletter-mail-error').html('');

                    let data = {};
                    data['receivers_roles'] = val;
                    data['email_template_id'] = $('#email_template_id').val();

                    let url = "{{ route('newsletter.bulk.send') }}"
                    $.ajax({
                        type: "get",
                        url: url,
                        data: data,
                        success: function (response) {
                            console.log(response);
                            if(response.status == true){
                                $('#exampleModal1').modal('hide');
                                toastr.success(response.message);
                            }
                        }
                    });

                }
            });

            $(document).on('click', '.sendMailToNewsLatterMail', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                $('#email_template_id').val(id);
                $('#comment-modal1').modal('show');
            });
            $(document).on('click', '.smssendBtn', function(e) {

                e.preventDefault();
                let val = [];
                $("input:checkbox[name=newsletter_mail_receivers]:checked").each(function() {
                    val.push($(this).val());
                });

                if(val.length == 0){
                    $('.newsletter-mail-error').html('* please select Atleast one option');
                }else{
                    $('.newsletter-mail-error').html('');

                    let data = {};
                    data['receivers_roles'] = val;
                    data['email_template_id'] = $('#email_template_id').val();

                    let url = "{{ route('sms.bulk.send') }}"
                    $.ajax({
                        type: "get",
                        url: url,
                        data: data,
                        success: function (response) {
                            console.log(response);
                            if(response.status == true){
                                $('#comment-modal1').modal('hide');
                                toastr.success(response.message);
                            }
                        }
                    });

                }
            });


            $(document).on('click', '.newsLetterCreateBtn', function(e) {
                e.preventDefault();
                if ($("#newsLetterCreateForm").valid() == true) {


                    let url = "{{ route('newsletter.emailtemplate.create') }}";
                    let data = {};
                    data['name'] = $('#name').val();
                    data['subject'] = $('#subject').val();
                    data['description'] = $('#description').val();

                    $.ajax({
                        type: "get",
                        url: url,
                        data: data,
                        success: function(response) {
                            if (response.message == 'Error : Validation Error') {
                                console.log(response.data.name);
                                let namevalidationerror = response.data.name;
                                $('.nameValidationError').html(namevalidationerror);
                            } else if (response.slug != undefined) {
                                $('.nameValidationError').html('');
                                let url = window.location.origin +
                                    "/admin/settings/email/templates/edit/plugins/newsletter/" + response
                                    .slug + "?is_template=1";
                                window.location = url;
                            }
                        }
                    });


                }

            });
            // this is for validation and message
            $("#newsLetterCreateForm").validate({
                errorClass: 'is-invalid',
                rules: {
                    name: {
                        required: true,
                    },
                    subject: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "Please enter Template name",
                    },
                    subject: {
                        required: "Please enter Subject",
                    },
                },
            });
            $(document).ready(function(){
                setTimeout(() => {
                    $('.sorting_desc').trigger('click');
                }, 2000);
            })
        </script>
    @endsection
@endif
