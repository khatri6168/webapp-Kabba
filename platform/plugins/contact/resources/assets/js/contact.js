class ContactPluginManagement {
    init() {
        $(document).on('click', '.answer-trigger-button', (event) => {
            event.preventDefault()
            event.stopPropagation()

            const answerWrapper = $('.answer-wrapper')
            if (answerWrapper.is(':visible')) {
                answerWrapper.fadeOut()
            } else {
                answerWrapper.fadeIn()
            }

            new EditorManagement().init()
        })

        $(document).on('click', '.answer-send-button', (event) => {
            event.preventDefault()
            event.stopPropagation()

            $(event.currentTarget).addClass('button-loading')

            let message = $('#message').val()
            if (typeof tinymce != 'undefined') {
                message = tinymce.get('message').getContent()
            }

            $.ajax({
                type: 'POST',
                cache: false,
                url: route('contacts.reply', $('#input_contact_id').val()),
                data: {
                    message: message,
                },
                success: (res) => {
                    if (!res.error) {
                        $('.answer-wrapper').fadeOut()
                        if (typeof tinymce != 'undefined') {
                            tinymce.get('message').setContent('')
                        } else {
                            $('#message').val('')
                            const domEditableElement = document.querySelector('.answer-wrapper .ck-editor__editable')
                            if (domEditableElement) {
                                const editorInstance = domEditableElement.ckeditorInstance

                                if (editorInstance) {
                                    editorInstance.setData('')
                                }
                            }
                        }

                        Botble.showSuccess(res.message)
                        $('#reply-wrapper').load(window.location.href + ' #reply-wrapper > *')
                    }

                    $(event.currentTarget).removeClass('button-loading')
                },
                error: (res) => {
                    $(event.currentTarget).removeClass('button-loading')
                    Botble.handleError(res)
                },
            })
        })
    }
}
function deleteNote(id)
{

}
function updateNote(id)
{
  var myModal = new bootstrap.Modal(document.getElementById('NotesModal'), {
    keyboard: false
  })
  myModal.show()
}
$(document).ready(() => {
    new ContactPluginManagement().init()

    $('.control-label-1').append(`<span class="add-button-custome d-inline ms-2" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color: red;width: auto;padding: 2px;height: fit-content;border-radius: 4px;"><i class="fa fa-plus text-white" aria-hidden="true"></i></span>`);
    $('.control-label-2').append("<span class=\"add-button-custome d-inline ms-2\" data-bs-toggle=\"modal\" data-bs-target=\"#NotesModal\" style=\"background-color: red;width: auto;padding: 2px;cursor:pointer;height: fit-content;border-radius: 4px;\"><i class=\"fa fa-plus text-white\" aria-hidden=\"true\"></i></span>");
    console.log(window.location.href);
    // $('#companyCreateForm').submit(function(e){
    //     e.preventDefault(); 
    //     alert('test');
    // });

    $(document).on('click', '.notesCreateBtn', function (e) {
        e.preventDefault();
        var company_name = $('#notes_name').val();
        if (company_name != '') {
          $('#notes_nameHelp').html('');
          var url = window.location.href+"/notes/create";
          var data = {
            'notes':company_name,
            'contact_id': $('#company_id_notes').val()
          };
          $.ajax({
            type: "get",
            url: url,
            data: data,
            success: function success(response) {
              console.log(response);
              if (response.status == true) {
                $('#notes_name').val("");
                
               
                toastr.success('Notes Data Added Successfully');
                var notes = response.data;
               
                $('.notesModalClose').trigger('click');
                $('#notest_list').append("<p>"+company_name+"</p>");
                
              } else {
                toastr.error(response.message);
              }
            }
          });
        } else {
          $('#notes_nameHelp').html('Please Enter Notes');
        }
      });

    $(document).on('click', '.companyCreateBtn', function (e) {
        e.preventDefault();
        
        let company_name = $('#company_name').val();
        if (company_name != ''){
            
            $('#emailHelp').html('');
            var url = window.location.origin + '/admin/contacts/company/create';
            let data = {
                'company_name' : $('#company_name').val(),
                'company_email': $('#company_email').val(),
                'company_country': $('#company_country').val(),
                'company_url': $('#company_url').val(),
                'company_address': $('#company_address').val()
            };

            $.ajax({
                type: "get",
                url: url,
                data: data,                
                success: function (response) {
                    console.log(response);
                    if (response.status == true){
                        $('#company_name').val("");
                        $('#company_email').val("");
                        $('#company_country').val("");
                        $('#company_url').val("");
                        $('#company_address').val("");
                        $('#company_address').html("");
                        $('#modalCloseBtn').click();
                        toastr.success('Company Data Added Successfully');
                        let company = response.data;
                        let company_id = company['id'];
                        let company_name = company['company_name'];
                        $('#company').append(`<option value="${company_id}" selected>${company_name}</option>`);
                        console.log(company_id);


                    }else{
                        toastr.error(response.message);
                    }
                }
            });
        }else{            
            $('#emailHelp').html('Please Enter Company Name');            
        }
    })
    $(document).on('keyup', '#company_name',function(e){
        e.preventDefault();
        if (company_name == "") {
            $('#emailHelp').html('Please Enter Company Name');
        } else {
            $('#emailHelp').html('');
        }
    })

    // // this is for validation and message
    // $("#companyCreateForm").validate({
    //     errorClass: 'is-invalid',
    //     rules: {
    //         company_name: {
    //             required: true,
    //         },
    //     },
    //     messages: {
    //         company_name: {
    //             required: "Please enter Company name",
    //         },
    //     },
    // });

    
    

})
