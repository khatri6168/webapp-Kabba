@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    @include('core/table::base-table')
@stop
@if (\Request::segment(2) == 'newsletters')
    @section('javascript')
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

        <script>
            $('.table-wrapper').after(`
            <div class="row">
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl w-100">
                    <div class="modal-content">
                    <div class="modal-header p-2" style="background-color:transparent;">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">NewsLetter Template</h1>                        
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">                        
                        <div class="row p-2">
                            <div class="mb-2" style="background:linear-gradient(to top, rgba(229,229,229,1) 0%,rgba(255,255,255,0) 100%) bottom,linear-gradient(to top, rgba(229,229,229,1) 0%,rgba(255,255,255,0) 100%) top;">
                            <p class="p-2 pb-0">Create</p>
                            </div>
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
                                <div class="row"><div class="col-2"><button type="button" class="btn btn-primary newsLetterCreateBtn">save</button></div></div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="modalCloseBtn" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>                        
                    </div>
                    </div>
                </div>
            </div>`);

            $('.table-wrapper').after(`
            <div class="row">
                <!-- Modal -->
                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl w-100">
                    <div class="modal-content">
                    <div class="modal-header p-2" style="background-color:transparent;">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Send Mail NewsLetter Template</h1>                        
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">                        
                        <div class="row p-2">
                            <div class="mb-2" style="background:linear-gradient(to top, rgba(229,229,229,1) 0%,rgba(255,255,255,0) 100%) bottom,linear-gradient(to top, rgba(229,229,229,1) 0%,rgba(255,255,255,0) 100%) top;">
                            <p class="p-2 pb-0">Bulk Mail send to user of selected template</p>
                            </div>
                            <form action="#" id="newsLetterSendmailForm" class="">
                                <input type="hidden" name="email_template_id" id="email_template_id"/>
                                <div class="form-check form-check-inline m-2">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="customers" name="newsletter_mail_receivers">
                                    <label class="form-check-label" for="inlineCheckbox1">Customers</label>
                                </div>
                                <div class="form-check form-check-inline m-2">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="contacts" name="newsletter_mail_receivers">
                                    <label class="form-check-label" for="inlineCheckbox2">Contacts</label>
                                </div>
                                <div class="text-danger newsletter-mail-error"></div>
                                <div class="row"><div class="col-2"><button type="button" class="btn btn-primary newsLetterMailsendBtn">send</button></div></div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="modalCloseBtn" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>                        
                    </div>
                    </div>
                </div>
            </div>`);


            $(document).on('click', '.custome-email-template-create', function(e) {
                e.preventDefault();
                $('#exampleModal').modal('show');
            });

            $(document).on('click', '.sendMailToNewsLatterMail', function(e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                $('#email_template_id').val(id);
                $('#exampleModal1').modal('show');
            });
            // $(document).on('click', '.newsLetterMailsendBtn', function(e) {

            //     e.preventDefault();
            //     let val = [];
            //     $("input:checkbox[name=newsletter_mail_receivers]:checked").each(function() {
            //         val.push($(this).val());
            //     });

            //     if(val.length == 0){
            //         $('.newsletter-mail-error').html('* please select Atleast one option');
            //     }else{
            //         $('.newsletter-mail-error').html('');

            //         let data = {};
            //         data['receivers_roles'] = val;
            //         data['email_template_id'] = $('#email_template_id').val();

            //         let url = "{{ route('newsletter.bulk.send') }}"
            //         $.ajax({
            //             type: "get",
            //             url: url,
            //             data: data,
            //             success: function (response) {
            //                 console.log(response);
            //             }
            //         });

            //     }
            // });
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
