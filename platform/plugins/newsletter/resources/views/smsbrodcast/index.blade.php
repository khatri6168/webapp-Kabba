@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script>
    $(document).ready(function(){
        new DataTable('#example');
        $('.next1').click(function(){
            let selecttext = $('.sms_content').val();


            if(selecttext.length > 0){
                $('.second_step').show();
                $('.first_step').hide();
                $("ul#gr-progress-bar li:eq(1)").addClass("active");
                $("ul#gr-progress-bar li:eq(0)").addClass("active");
                var allcon = $('input[name="checkoption"]:checked').val();
                if(allcon == 1){
                    $('.search_contact').trigger('click');
                }


            }else{
                alert("Please select SMS Content");
            }


        })
        $('.next2').click(function(){
            var allcon = $('input[name="checkoption"]:checked').val();

            if(allcon == 2){

                val = []
                $(':checkbox:checked').each(function(i){
                val[i] = $(this).val();
                });
                $('.taglist').val(JSON.stringify(val));
                $('.queoption').val(allcon);

            }else{
                var allcon = 1
                $('.queoption').val(allcon);


            }
            console.log('tagval',allcon)
            if(allcon > 0){
                $('.third_step').show();
                $('.first_step').hide();
                $('.second_step').hide();
               // $("ul#gr-progress-bar li:eq(1)").removeClass("active");
                //$("ul#gr-progress-bar li:eq(0)").removeClass("active");
                $("ul#gr-progress-bar li:eq(2)").addClass("active");
            }else{
                alert("Please select Option To Proceed");
            }


        })

        $('.priv1').click(function(){
            $('.second_step').hide();
            $('.first_step').show();
            $("ul#gr-progress-bar li:eq(0)").addClass("active");
            $("ul#gr-progress-bar li:eq(1)").removeClass("active");
        })
        $('.priv2').click(function(){
            $('.second_step').show();
            $('.first_step').hide();
            $('.third_step').hide();
            $("ul#gr-progress-bar li:eq(0)").addClass("active");
            $("ul#gr-progress-bar li:eq(1)").addClass("active");
            $("ul#gr-progress-bar li:eq(2)").removeClass("active");
        })

        $('.checkoption').click(function(){
            let checkoption = $(this).val();
            if(checkoption == 1){
                $('.gr-tag-box').hide();

            }
            if(checkoption == 2){
                $('.gr-tag-box').show();
            }
            console.log('check',checkoption);
        })
        $(document).on('click', '.custome-email-template-create', function(e) {
                e.preventDefault();
                $('#comment-modal').modal('show');
            });

        $(document).on('click','#save-comment-button',function(){
            let url = "{{ route('smsbrodcast.create') }}";
            let data = {};
            data['sms_title'] =  $('.sms_name').val();
            data['smstdescription'] = $('.smsbody').val();
            $.ajax({
                type: "post",
                url: url,
                data: data,
                success: function(response) {
                    console.log('response',response);

                    // window.location.replace(
                    //     "{{route('smsbrodcast.process')}}"
                    //     );
                     window.location.reload(true);
                }
            });

        })

        $(document).on('change','.smsTemplateID',function(){
            let url = "{{ route('getsmscontent') }}";
            let smsid = $(this).val();
            let data = {};
            data['id'] =  smsid

            $.ajax({
                type: "post",
                url: url,
                data: data,
                success: function(response) {
                    let smstemplate = JSON.parse(response);
                    //console.log('res',smstemplate[0].description)
                    $('.sms_content').val(smstemplate[0].description)

                    // window.location.replace(
                    //     "{{route('smsbrodcast.process')}}"
                    //     );
                     //window.location.reload(true);
                }
            });

        })

        $('.add_que').click(function(){
            let queoption = $('.queoption').val();
            let contags = $('.taglist').val();
            let numberOfUsers = $('.number_of_users').val();
            let url = "{{ route('sms.bulk.send') }}"
            let smstemplateid = $('.smsTemplateID').val();
            let data = {}
            data['smstemplateid'] = smstemplateid
            data['smsoption'] = queoption
            data['number_of_users'] = numberOfUsers
            if(contags === 'undefined'){
                data['smsoption'] = queoption
            }else{
                data['taglist'] = contags
            }

            $.ajax({
                type: "get",
                url: url,
                data: data,
                success: function(response) {
                    console.log('res',response)

                    window.location.replace(
                        "{{route('smslogs')}}"
                        );
                     //window.location.reload(true);
                }
            });

        })


        $('.search_contact').click(function(){
            let url = "{{ route('smsbrodcast.searchcontacts') }}";
            var val = [];
            var allcon = $('input[name="checkoption"]:checked').val();
            $(':checkbox:checked').each(function(i){
                val[i] = $(this).val();
            });
            var data = {}

            if(allcon == 1){
                data['all'] = 1;
            }else{
                data['tags'] = val;
            }


            data['tags'] = val;
            $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    beforeSend: function(){
                        // Show image container
                        $(".loader").show();
                    },
                    success: function(response) {
                        console.log('response',response);
                        if(response){
                            let html = '';
                            let totalrecords = 0;
                            let allrecords =  response.length;

                            if(data['all'] == 1){
                                $('.total_contact').html(allrecords);
                                $(".number_of_users").val(allrecords);
                            }

                            if(response.count){
                                for(let k = 0;  k < response.count.length; k++){
                                    totalrecords += parseInt(response.count[k]);
                                }
                            }

                            if(response.totalrecords){
                                for (let i = 0; i < response.totalrecords.length; i++) {
                                    //totalrecords += parseInt(response.count)
                                    if(response.totalrecords[i]){
                                        //totalrecords += parseInt(response[i].length)
                                        for(let j = 0; j < response.totalrecords[i].length; j++){
                                            //totalrecords +=parseInt(response[i].length);
                                            let name = response.totalrecords[i][j]['name'];
                                            if(name == null){
                                                if(response.totalrecords[i][j]['first_name']){
                                                    name = response.totalrecords[i][j]['first_name']+' '+ response.totalrecords[i][j]['last_name']
                                                }else{
                                                    name = '--';
                                                }
                                            }else{
                                                name = response.totalrecords[i][j]['name']
                                            }
                                            let email = response.totalrecords[i][j]['email'];
                                            if(email == null){
                                                email = '--'
                                            }else{
                                                email = response.totalrecords[i][j]['email']
                                            }
                                            let phone = response.totalrecords[i][j]['phone'];
                                            if(name == null){
                                                phone = '--'
                                            }else{
                                                phone = response.totalrecords[i][j]['phone']
                                            }
                                            let contactTag = response.totalrecords[i][j]['contactTag'];
                                            if(contactTag == null){
                                                contactTag = '--'
                                            }else{
                                                contactTag = response.totalrecords[i][j]['contactTag']
                                            }
                                            html += '<tr>';
                                            html +='<td>'+ name +'</td>';
                                           // html +='<td>'+ email +'</td>';
                                            html +='<td>'+ formatPhoneNumber(phone)+'</td>';
                                            html +='<td>'+ contactTag.replace(/,/g, ', ') +'</td>';
                                            html += '</tr>';


                                        }


                                    }
                                    console.log(totalrecords)
                                }

                                $('.total_contact').html(totalrecords);
                                $(".number_of_users").val(totalrecords);
                            }

                            if(data['all'] == 1){
                                for (let i = 0; i < response.length; i++) {
                                    let name = response[i]['name'];
                                    if(name == null){
                                        if(response[i]['first_name']){
                                            name = response[i]['first_name']+' '+ response[i]['last_name']
                                        }else{
                                            name = '--';
                                        }

                                    }else{
                                        name = response[i]['name']
                                    }
                                    let email = response[i]['email'];
                                    if(email == null){
                                        email = '--'
                                    }else{
                                        email = response[i]['email']
                                    }
                                    let phone = response[i]['phone'];
                                    if(name == null){
                                        phone = '--'
                                    }else{
                                        phone = response[i]['phone']
                                    }
                                    let contactTag = response[i]['contactTag'];
                                    if(contactTag == null){
                                        contactTag = '--'
                                    }else{
                                        contactTag = response[i]['contactTag']
                                    }
                                    html += '<tr>';
                                    html +='<td>'+name+'</td>';
                                    //html +='<td>'+email+'</td>';
                                    html +='<td>'+formatPhoneNumber(phone)+'</td>';
                                    html +='<td>'+contactTag.replace(/,/g, ', ')+'</td>';
                                    html += '</tr>';
                                }

                            }
                        console.log('totalrecords',totalrecords);
                        $('tbody').html(html);
                        }

                       // window.location.reload(true);
                    },
                    complete:function(data){
                        // Hide image container
                        $(".loader").hide();
                    }
                });
        })

    })
    function formatPhoneNumber(phoneNumberString) {
        if(/\([\d]+\)/.test(phoneNumberString)){
            var cleaned = phoneNumberString.replace(/[{()}]/g, '');
        }else{
            var cleaned = ('' + phoneNumberString).replace(/\D/g, '');
        }

        var match = cleaned.match(/^(1|)?(\d{3})(\d{3})(\d{4})$/);
        //console.log('match',match);
        if(match == null){
            return '+1 '+phoneNumberString
        }
        if (typeof match[1] != 'undefined') {
            var intlCode = (match[1] ? '+1 ' : '');
            console.log('match',match);
            return [intlCode, '(', match[2], ') ', match[3], '-', match[4]].join('');
        }

        if(typeof match[1] == 'undefined'){
            return '+1 '+'('+ match[2]+ ') '+ match[3]+ '-'+ match[4];
        }
        return null;
    }
</script>
<style>
.gr-step-form{    width: 100%;
    max-width: 750px;
    margin: 0 auto;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;}
.dataTables_empty{
    display:none;
}
.dataTables_info{
    display:none;
}
.dataTables_length{
    display:none;
}
.dataTables_filter{
    display:none;
}
.paginate_button{
    display:none;
}
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
.gr-btn-small{}
.gr-radio-btn{    border: none;}
.gr-radio-btn input[type=radio]{   border: none;}
.gr-radio-btn input[type=radio]:after{    background: #fff;
    border: 2px solid #36c6d3;
    border-radius: 50%;
    bottom: 0;
    content: "";
    height: 20px;
    left: 1px;
    margin: auto;
    position: absolute;
    right: 0;
    top: 0;
    width: 20px;}
.gr-radio-btn label {
    display: block;
    text-align: center;
    margin-bottom: 10px;
}
.gr-radio-btn input[type=radio]:checked:before {
    background: #36c6d3;
}
.desabled-radio{    pointer-events: none;}
.desabled-radio label{    color: #ddd;}
.desabled-radio input[type=radio]:after {
    border: 2px solid #ddd;}
.gr-box-space{border: 1px solid #aaa;}
.gr-tag-box > label{margin-bottom: 10px}
.gr-tag-group{    border: 15px solid #fff;
    padding: 0;
    max-height: 250px;
    display: block;
}
.gr-tag-group ul{
    column-count: 3;
}
input[type=radio]:checked:before{
    left:0 !important;
}
.gr-tag-group > label{}
.gr-tag {
    padding: 5px;    text-transform: capitalize;
    width:300px;
}
.gr-tag input[type=checkbox]{   display: inline-block;
    border: none;
    padding: 0;
    width: 16px;
    margin-right: 5px;
    vertical-align: middle;
    height: 20px;
    left: -2px;
    width: 20px;}
.gr-tag label{
    vertical-align: middle;
    font-weight: normal;
}
.gr-scroll {
  overflow-y: auto;
}
.gr-tag input[type=checkbox]:checked:after {
    border-color: #36c6d3;height: 20px;
    width: 20px;
}
.gr-tag input[type=checkbox]:before {
       border-color: #36c6d3;
    border-style: none none solid solid;
    border-width: 3px;
    content: "";
    height: 6px;
    left: 0px;
    margin: auto;
    position: absolute;
    right: 0;
    top: 5px;
    transition: transform .4s cubic-bezier(.45,1.8,.5,.75);
    width: 15px;
    z-index: 1;
}
.gr-scroll:active::-webkit-scrollbar-thumb,
.gr-scroll:focus::-webkit-scrollbar-thumb,
.gr-scroll:hover::-webkit-scrollbar-thumb {
    visibility: visible;
}
.gr-scroll::-webkit-scrollbar-thumb {
    background-color: darkgrey;
    visibility: hidden;
}

.gr-scroll::-webkit-scrollbar {
    width: 4px;
    height: 4px;
}
.gr-step-form .table-responsive table{
    margin-top: 10px !important;
    display: inline-table;
    width: 100%;
    max-width: 100%;
    border: 1px solid #ddd;
}
.gr-step-form .table-heading{
    font-weight: bold;
    text-align: right;
    margin-bottom: 5px;
}
@media(max-width:650px){
    #gr-progress-bar li {
    font-size: 16px;
    max-width: 118px;
    width: 33%;
}
#gr-progress-bar {
    margin-bottom: 15px;
}
.gr-tag-group ul{
    column-count: 2;
}
}
</style>
<div class="row">
                <!-- Modal -->
                <div id="comment-modal" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>SMS Brodcast</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close"></button></div> <div class="modal-body with-padding">
                <label for="comment-text">Title</label>
                <input type="text" name="comment-text"  class="form-control sms_name" />
                <label for="comment-text">Description</label>
                <textarea name="comment-text" maxlength="150" id="comment-text" rows="4" class="form-control smsbody"></textarea>
                <em style="text-align:right;"><span class="type_char1">0</span>/150</em>
                </div> <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="float-start btn btn-warning">Cancel</button> <button id="save-comment-button" class="float-end btn btn-info " type="button">Save</button></div></div></div></div>
<div class="row">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-12">
        <div class="widget meta-boxes gr-step-form">
            <div class="widget-body">
                <form name="smsbrodcastprocess" method="post" action="" >
                    <div class="">
                        <h4 class="gr-form-heading">SMS Brodcast</h4>
                        <ul id="gr-progress-bar">
                            <li class="active">
                                <i class="fa fa-message"></i> <span>SMS</span>
                            </li>
                            <li>
                                <i class="fa fa-users"></i> <span>Target Audience</span>
                            </li>
                            <li>
                                <i class="fa fa-clock"></i> <span>Schedule</span>
                            </li>
                        </ul>
                        <div class="first_step gr-steps">
                            <div class="form-group mb-3 row">
                                <label for="smsTemplateID" class="col-sm-3 col-form-label">Select SMS Content</label>
                                <div class="col-sm-9 gr-btn-inline">
                                    <div class="ui-select-wrapper">
                                        <select class="form-control ui-select smsTemplateID" name="smsTemplateID">
                                        <option value="" >Select content</option>
                                            @if($smstemplate)
                                            @foreach($smstemplate as $template)
                                            <option value="{{$template->id}}" >{{$template->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <svg class="svg-next-icon svg-next-icon-size-16">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path>
                                            </svg>
                                        </svg>
                                    </div>
                                    <button type="button" class="btn btn-primary gr-btn-small custome-email-template-create">+ New Content</button>
                                </div>
                            </div>
                            <div class="form-group mb-5 row">
                                <label for="smsTemplateID" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <textarea name="sms_content" rows="10" class="form-control sms_content"></textarea>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info prev1">< Previous</button>
                            <button type="button" class="btn btn-info next1 float-end">Next ></button>
                        </div>

                        <div class="second_step gr-steps" style="display:none;">
                            <div class="form-group mb-3 row gr-radio-btn justify-content-center">
                                <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6 col-6">
                                    <label for="allcontacts" class="col-form-label">Send to Entire List</label>
                                    <input type="radio"  name="checkoption" checked={true} class="form-control checkoption" value="1">
                                </div>

                                <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6 col-6">
                                    <label for="target_audience" class="col-form-label">Target Audience</label>
                                    <input type="radio"  name="checkoption" class="form-control checkoption" value="2">
                                </div>
                            </div>

                            <div class="gr-tag-box mb-3" style="display:none;">
                                <label>Tags</label>
                                <div class="gr-box-space">
                                    <div class="gr-tag-group gr-scroll">
                                        <ul>
                                            @if($contacttags)
                                                @foreach($contacttags as $tag)
                                                <li class="gr-tag">
                                                    <input type="checkbox" name="smstag[]" id="contact-tag-{{$tag->id}}" class="form-control" value="{{$tag->name}}" />
                                                    <label for="contact-tag-{{$tag->id}}" class="tag-label">{{$tag->name}}</label>
                                                </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-4 col-3 text-start">
                                    <button type="button" class="btn btn-info priv1">< Previous</button>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-4 col-6 text-center">
                                    <button type="button" class="btn btn-info search_contact"><i class="fa fa-search"></i> Search Users</button>
                                    <div class="loader" style="display:none;" ><img src="https://rentnking.com/loader.gif" style="width:60px;" /></div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-4 col-3 text-end">
                                    <button type="button" class="btn btn-info next2">Next ></button>
                                </div>
                            </div>

                            <div class="portlet-body">
                                <p class="table-heading">You're about to send this SMS to: <span class="total_contact"></span> Users</p>
                                <div class="table-responsive table-has-actions table-has-filter">
                                <table id="example" class="table table-striped table-hover vertical-middle dataTable no-footer dtr-inline">
                                   <thead>
                                          <tr>
                                             <th>Name</th>
                                             <!-- <th>Email</th> -->
                                             <th>Phone</th>
                                             <th>Tags</th>
                                          </tr>
                                       </thead>
                                       <tbody>

                                       </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>

                        <div class="third_step gr-steps" style="display:none;">
                            <div class="form-group mb-5 row gr-radio-btn justify-content-center">
                                <div class="col-xxl-4 col-xl-4 col-lg-5 col-sm-6 col-6">
                                    <label for="allcontacts" class="col-form-label">Immediately Add to Queue</label>
                                    <input type="radio"  name="checkoption1" checked class="form-control checkoption" value="1">
                                    <input type="hidden" name="taglist" class="taglist" value="" />
                                    <input type="hidden" name="number_of_users" class="number_of_users" value="" />
                                    <input type="hidden" name="queoption" class="queoption" value="" />
                                </div>

                                <div class="col-xxl-4 col-xl-4 col-lg-5 col-sm-6 col-6 desabled-radio">
                                    <label for="target_audience" class="col-form-label">Schedule To Specific Time *Coming soon</label>
                                    <input type="radio"  name="checkoption1" class="form-control checkoption" value="2">
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-sm-6 col-6 text-start">
                                    <button type="button" class="btn btn-info priv2">< Previous</button>
                                </div>

                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-sm-6 col-6 text-end">
                                    <button type="button" class="btn btn-info add_que">Add to Queue ></button>
                                </div>
                            </div>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
