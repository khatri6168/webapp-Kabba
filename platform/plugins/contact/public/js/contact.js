/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************************************!*\
  !*** ./platform/plugins/contact/resources/assets/js/contact.js ***!
  \*****************************************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
var ContactPluginManagement = /*#__PURE__*/function () {
  function ContactPluginManagement() {
    _classCallCheck(this, ContactPluginManagement);
  }
  _createClass(ContactPluginManagement, [{
    key: "init",
    value: function init() {
      $(document).on('click', '.answer-trigger-button', function (event) {
        event.preventDefault();
        event.stopPropagation();
        var answerWrapper = $('.answer-wrapper');
        if (answerWrapper.is(':visible')) {
          answerWrapper.fadeOut();
        } else {
          answerWrapper.fadeIn();
        }
        new EditorManagement().init();
      });
      $(document).on('click', '.answer-send-button', function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(event.currentTarget).addClass('button-loading');
        var message = $('#message').val();
        if (typeof tinymce != 'undefined') {
          message = tinymce.get('message').getContent();
        }
        $.ajax({
          type: 'POST',
          cache: false,
          url: route('contacts.reply', $('#input_contact_id').val()),
          data: {
            message: message
          },
          success: function success(res) {
            if (!res.error) {
              $('.answer-wrapper').fadeOut();
              if (typeof tinymce != 'undefined') {
                tinymce.get('message').setContent('');
              } else {
                $('#message').val('');
                var domEditableElement = document.querySelector('.answer-wrapper .ck-editor__editable');
                if (domEditableElement) {
                  var editorInstance = domEditableElement.ckeditorInstance;
                  if (editorInstance) {
                    editorInstance.setData('');
                  }
                }
              }
              Botble.showSuccess(res.message);
              $('#reply-wrapper').load(window.location.href + ' #reply-wrapper > *');
            }
            $(event.currentTarget).removeClass('button-loading');
          },
          error: function error(res) {
            $(event.currentTarget).removeClass('button-loading');
            Botble.handleError(res);
          }
        });
      });
    }
  }]);
  return ContactPluginManagement;
}();
$(document).ready(function () {
  new ContactPluginManagement().init();
  //$('.control-label-1').append("<span class=\"add-button-custome d-inline ms-2\" data-bs-toggle=\"modal\" data-bs-target=\"#exampleModal\" style=\"background-color: red;width: auto;padding: 2px;height: fit-content;border-radius: 4px;\"><i class=\"fa fa-plus text-white\" aria-hidden=\"true\"></i></span><input type=\"checkbox\" name=\"sameascontact\" class=\"sameascontact\">Same as Above ");

  // $('#companyCreateForm').submit(function(e){
  //     e.preventDefault(); 
  //     alert('test');
  // });

  $(document).on('click', '.companyCreateBtn', function (e) {
    e.preventDefault();
    var company_name = $('#company_name').val();
    if (company_name != '') {
      $('#emailHelp').html('');
      var url = window.location.origin + '/admin/contacts/company/create';
      var data = {
        'company_name': $('#company_name').val(),
        'company_email': $('#company_email').val(),
        'company_country': $('#company_country').val(),
        'company_url': $('#company_url').val(),
        'company_address': $('#company_address').val()
      };
      $.ajax({
        type: "get",
        url: url,
        data: data,
        success: function success(response) {
          console.log(response);
          if (response.status == true) {
            $('#company_name').val("");
            $('#company_email').val("");
            $('#company_country').val("");
            $('#company_url').val("");
            $('#company_address').val("");
            $('#company_address').html("");
            $('#modalCloseBtn').click();
            toastr.success('Company Data Added Successfully');
            var company = response.data;
            var company_id = company['id'];
            var _company_name = company['company_name'];
            $('#exampleModal').hide();
            $('#company').append("<option value=\"".concat(company_id, "\" selected>").concat(_company_name, "</option>"));
            console.log(company_id);
          } else {
            toastr.error(response.message);
          }
        }
      });
    } else {
      $('#emailHelp').html('Please Enter Company Name');
    }
  });
  $(document).on('keyup', '#company_name', function (e) {
    e.preventDefault();
    if (company_name == "") {
      $('#emailHelp').html('Please Enter Company Name');
    } else {
      $('#emailHelp').html('');
    }
  });

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
});
/******/ })()
;
