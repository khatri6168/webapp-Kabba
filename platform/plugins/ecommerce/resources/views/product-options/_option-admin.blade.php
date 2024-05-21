@php
    $value = count($values) ? ($values[0] ?? []) : [];
    $isDefaultLanguage = ! defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME') ||
        ! request()->input('ref_lang') ||
        request()->input('ref_lang') == Language::getDefaultLocaleCode();
@endphp

<style>
    #tooltip {
  position: absolute;
  margin-top:-110px;
  margin-left:386px;
  width: 200px;
  background-color: rgb(0, 0, 0, 0.7);
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
}

#valuetooltip {
  position: absolute;
  margin-top:-110px;
  margin-left:536px;
  width: 200px;
  background-color: rgb(0, 0, 0, 0.7);
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
}

#commenttooltip {
  position: absolute;
  margin-top:-178px;
  margin-left:696px;
  width: 200px;
  background-color: rgb(0, 0, 0, 0.7);
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
}

</style>

<div class="col-md-12 option-setting-tab" @if ($isDefaultLanguage) style="display: none" @endif id="option-setting-multiple">
    <table class="table table-bordered setting-option">
        <thead>
        <tr>
            @if ($isDefaultLanguage)
                <th scope="col">#</th>
            @endif
            <tooltip id='tooltip' style='display:none'>
            This is the amount the Option will alter Product Price if selected. Using Options to affect the Product Price is optional.
            </tooltip>
            <th scope="col">{{ trans('plugins/ecommerce::product-option.label') }} </th>
            @if ($isDefaultLanguage)
                <th scope="col">{{ trans('plugins/ecommerce::product-option.price') }} <span id ="labelhelp" style="float:right;"><i class="fa fa-question-circle" aria-hidden="true" style="font-size:14px;"></i></span></th>
                @if(isset($isRental) && $isRental)
                <tooltip id='valuetooltip' style='display:none'>
                If left blank, the Option default condition is “not selected”. If you select “Checked”, the Option default condition will be "selected".
            </tooltip>
                    <th scope="col" class="rental-div">{{ trans('Value') }} <span id ="labelvalue" style="float:right;"><i class="fa fa-question-circle" aria-hidden="true" style="font-size:14px;"></i></span></th>
                    
                    <tooltip id='commenttooltip' style='display:none'>
                    If you select “Checked”, you can add a comment that appears in a pop-up window when a customer deselects the pre-selected check box for this Option. 
 
 This is often used to persuade the customer to not deselect the Option. 
            </tooltip>
                    <th scope="col" class="rental-div">{{ trans('Comment') }} <span id ="labelcomment" style="float:right;"><i class="fa fa-question-circle" aria-hidden="true" style="font-size:14px;"></i></span></th>
                @endif
                <th scope="col" colspan="2">{{ trans('plugins/ecommerce::product-option.price_type') }}</th>
            @endif
            
        </tr>
        </thead>
        <tbody class="option-sortable">
        @if ($values->count())
            @foreach ($values as $key => $value)
                <tr class="option-row ui-state-default" data-index="{{ $key }}">
                    <input type="hidden" name="options[{{ $key }}][id]" value="{{ $value->id }}">
                    <input type="hidden" name="options[{{ $key }}][order]" value="{{ $value->order !== 9999 ? $value->order : $key }}">
                    @if ($isDefaultLanguage)
                        <td class="text-center">
                            <i class="fa fa-sort"></i>
                        </td>
                    @endif
                    <td>
                        <input type="text" class="form-control option-label" name="options[{{ $key }}][option_value]" value="{{ $value->option_value }}"
                               placeholder="{{ trans('plugins/ecommerce::product-option.label_placeholder') }}"/>
                    </td>
                    @if ($isDefaultLanguage)
                        <td>
                            <input type="number" class="form-control affect_price" name="options[{{ $key }}][affect_price]" value="{{ $value->affect_price }}"
                                   placeholder="{{ trans('plugins/ecommerce::product-option.affect_price_label') }}"/>
                        </td>
                        @if(isset($isRental) && $isRental)
                        <td class="rental-div">
                            <select class="form-select value_type" name="options[{{ $key }}][value_type]">
                                <option {{ $value->value_type == 0 ? 'selected' : ''}} value="0">{{ trans('Blank') }}</option>
                                <option {{ $value->value_type == 1 ? 'selected' : ''}} value="1">{{ trans('Checked') }}</option>
                            </select>
                        </td>
                         <td class="rental-div">
                            @if(isset($value->comment) && $value->comment)
                                <button class="btn btn-info comment-btn edit-comment" type="button" data-key="{{$key}}">{{ trans('Edit Comment') }}</button>
                            @else
                                <button class="btn btn-success comment-btn add-comment" type="button" data-key="{{$key}}">{{ trans('Add Comment') }}</button>
                            @endif
                            <input type="hidden" class="form-control hidden-comment " id="comment_{{$key}}" name="options[{{ $key }}][comment]" value="{{ $value->comment }}"/>
                        </td>
                        @endif
                        <td>
                            <select class="form-select affect_type" name="options[{{ $key }}][affect_type]">
                                <option {{ $value->affect_type == 0 ? 'selected' : ''}} value="0">{{ trans('plugins/ecommerce::product-option.fixed') }}</option>
                                <option {{ $value->affect_type == 1 ? 'selected' : ''}} value="1">{{ trans('plugins/ecommerce::product-option.percent') }}</option>
                            </select>
                        </td>
                        <td style="width: 50px">
                            <button class="btn btn-default remove-row" data-index="0"><i class="fa fa-trash"></i></button>
                        </td>
                    @endif
                </tr>
            @endforeach
        @else
            <tr class="option-row" data-index="0">
                @if ($isDefaultLanguage)
                    <td class="text-center">
                        <i class="fa fa-sort"></i>
                    </td>
                @endif
                <td>
                    <input type="text" class="form-control option-label" name="options[0][option_value]" value=""
                           placeholder="{{ trans('plugins/ecommerce::product-option.label_placeholder') }}"/>
                </td>
                @if ($isDefaultLanguage)
                    <td>
                        <input type="number" class="form-control affect_price" name="options[0][affect_price]" value=""
                               placeholder="{{ trans('plugins/ecommerce::product-option.affect_price_label') }}"/>
                    </td>
                    @if(isset($isRental) && $isRental)
                        <td class="rental-div">
                            <select class="form-select value_type" name="options[0][value_type]">
                                <option value="0">{{ trans('Blank') }}</option>
                                <option value="1">{{ trans('Checked') }}</option>
                            </select>
                        </td>
                         <td class="rental-div">
                            <button class="btn btn-success comment-btn add-comment" type="button" data-key="0">{{ trans('Add Comment') }}</button>
                            <input type="hidden" class="form-control hidden-comment" id="comment_0" name="options[0][comment]" value=""/>
                        </td>
                    @endif
                    <td>
                        <select class="form-select affect_type" name="options[0][affect_type]">
                            <option value="0">{{ trans('plugins/ecommerce::product-option.fixed') }}</option>
                            <option value="1">{{ trans('plugins/ecommerce::product-option.percent') }}</option>
                        </select>
                    </td>
                    <td style="width: 50px">
                        <button class="btn btn-default remove-row" data-index="0"><i class="fa fa-trash"></i></button>
                    </td>
                @endif
            </tr>
        @endif
        </tbody>
    </table>
    @if ($isDefaultLanguage)
        <button type="button" class="btn btn-info mt-3 add-new-row" id="add-new-row">{{ trans('plugins/ecommerce::product-option.add_new_row') }}</button>
    @endif
</div>

@if ($isDefaultLanguage)
    <div class="empty">{{ trans('plugins/ecommerce::product-option.please_choose_option_type') }}</div>
@endif
 <x-core-base::modal
    id="comment-modal"
    :title="trans('Comment')"
    button-id="save-comment-button"
    button-type="button"
    :button-label="trans('submit')"
    size="md">
    <label for="comment-text">Comment</label>
    <input type="hidden" id="comment-id"/>
    <textarea class="form-control" name="comment-text" id="comment-text"></textarea>

</x-core-base::modal>
<script type="text/javascript">
    'use strict'
    $(document).ready(function() {
        let jsOption = {
            currentType: 'N/A',
            init() {
                this.initFormFields($('.option-type').val())
                this.eventListeners()
                $('.option-sortable').sortable({
                    stop: function() {
                        let idsInOrder = $('.option-sortable').sortable('toArray', { attribute: 'data-index' })
                        idsInOrder.map(function(id, index) {
                            $('.option-row[data-index="' + id + '"]').find('.option-order').val(index)
                        })
                    },
                })
            },
            addNewRow() {
                $('.add-new-row').click(function() {
                    let table = $(this).parent().find('table tbody')
                    let tr = table.find('tr').last().clone()
                    let labelName = 'options[' + table.find('tr').length + '][option_value]',
                        affectName = 'options[' + table.find('tr').length + '][affect_price]',
                        affectTypeName = 'options[' + table.find('tr').length + '][affect_type]',
                        value_type = 'options[' + table.find('tr').length + '][value_type]',
                        hidden_comment = 'options[' + table.find('tr').length + '][comment]',
                        comment = table.find('tr').length;
                    tr.find('.option-label').attr('name', labelName)
                    tr.find('.affect_price').attr('name', affectName)
                    tr.find('.affect_type').attr('name', affectTypeName)
                    tr.find('.value_type').attr('name', value_type)
                    tr.find('.comment-btn').attr('data-key', comment)
                    tr.find('.value_type').attr('name', value_type);
                    tr.find('.hidden-comment').attr('name', hidden_comment).attr('id', 'comment_' + table.find('tr').length);
                    tr.find('.comment-btn').attr('data-key', table.find('tr').length);
                    table.append(tr)
                    $(".comment-btn").each(function(index, el) {
                        var closest_value_type = $(this).closest('tr').find('.value_type').val();
                        if (closest_value_type == 0) {
                            $(this).text("{{ trans('Add Comment') }}").removeClass('add-comment edit-comment btn-success btn-info').addClass('btn-secondary').prop('disabled', true);
                        } else {
                            if($(this).data('value')){
                                $(this).text("{{ trans('Edit Comment') }}").removeClass('add-comment').addClass('edit-comment').removeClass('btn-success').addClass('btn-info');
                            }
                        }
                    });
                })
                return this
            },
            removeRow() {
                $('.option-setting-tab').on('click', '.remove-row', function() {
                    let table = $(this).parent().parent().parent()
                    if (table.find('tr').length > 1) {
                        $(this).parent().parent().remove()
                    } else {
                        return false
                    }
                })
                return this
            },
            eventListeners() {
                this.onOptionChange()
                this.addNewRow().removeRow()
            },
            onOptionChange() {
                let self = this
                $('.option-type').change(function() {
                    let value = $(this).val()
                    this.currentType = value
                    self.initFormFields(value)

                })
            },
            initFormFields(value) {
                this.currentType = value
                if (value !== 'N/A') {
                    value = value.split('\\')
                    let id = value[value.length - 1]
                    if(id == "Rental"){
                        $(".rental-div").show();
                    } else {
                        $(".rental-div").hide();
                        $(".value_type").val(0);
                        $(".hidden-comment").val("");
                        $(".comment-btn").text("{{ trans('Add Comment') }}").addClass('add-comment').removeClass('edit-comment').addClass('btn-success').removeClass('btn-info');
                    }
                    if (id !== 'Field') {
                        id = 'multiple'
                    }
                    $('.empty, .option-setting-tab').hide()
                    id = '#option-setting-' + id.toLowerCase()
                    $(id).show()
                }
            },
        }
        jsOption.init()
    });

    $(document).ready(function($) {

        $('#save-comment-button').removeAttr("type").attr("type", "button");
        $(document).on('click', '.add-comment', function(event) {
            $("#comment-text").val("");
            $("#comment-id").val($(this).data('key'));
            $('#comment-modal').modal('show');
        });
        $(document).on('click', '.edit-comment', function(event) {
            var key = $(this).data('key');
            $("#comment-text").val($("#comment_"+key).val());
            $("#comment-id").val(key);
            $('#comment-modal').modal('show');
        });
        $(document).on('click', '#save-comment-button', function(event) {
            var key = $("#comment-id").val();
            console.log(key,$(".comment-btn[data-key='"+key+"']"));
            $("#comment_"+key).val($("#comment-text").val());
            if($("#comment-text").val()){
                $(".comment-btn[data-key='"+key+"']").text("{{ trans('Edit Comment') }}").removeClass('add-comment').addClass('edit-comment').removeClass('btn-success').addClass('btn-info');
            } else {
                $(".comment-btn[data-key='"+key+"']").text("{{ trans('Add Comment') }}").addClass('add-comment').removeClass('edit-comment').addClass('btn-success').removeClass('btn-info');
            }
            $('#comment-modal').modal('hide');
        });

        $(document).on('change', '.value_type', function(event) {
            if ($(this).val() == 0) {
                $(this).closest('tr').find('.comment-btn').text("{{ trans('Add Comment') }}").removeClass('add-comment edit-comment btn-success btn-info').addClass('btn-secondary').prop('disabled', true);
            } else {
                $(this).closest('tr').find('.comment-btn').text("{{ trans('Add Comment') }}").removeClass('btn-secondary').addClass('add-comment btn-success').prop('disabled', false);
            }
        });
        $(".comment-btn").each(function(index, el) {
            var closest_value_type = $(this).closest('tr').find('.value_type').val();
            if (closest_value_type == 0) {
                $(this).text("{{ trans('Add Comment') }}").removeClass('add-comment edit-comment btn-success btn-info').addClass('btn-secondary').prop('disabled', true);
            } else {
                if($(this).data('value')){
                    $(this).text("{{ trans('Edit Comment') }}").removeClass('add-comment').addClass('edit-comment').removeClass('btn-success').addClass('btn-info');
                }
            }
        });

        /*$('.add-new-row').click(function() {
             setTimeout(function() {
                    let table = $(this).parent().find('table tbody');
                    let tr = table.find('tr').last();
                    let count = table.find('.affect_price').last().attr('name').replace("options[","").replace("][affect_price]","");
                    let value_type = 'options[' + count + '][value_type]',
                        hidden_comment = 'options[' + count + '][comment]',
                        comment = count;
                    tr.find('.value_type').attr('name', value_type);
                    tr.find('.hidden-comment').attr('name', hidden_comment).attr('id', 'comment_' + count);
                    tr.find('.comment-btn').attr('data-key', comment);
                    // table.append(tr);
                }.bind(this), 1000);
            })*/
    });


const btn = document.getElementById('labelhelp'),
tooltip = document.getElementById('tooltip');
const btn1 = document.getElementById('labelvalue'),
tooltip1 = document.getElementById('valuetooltip');
const btn2 = document.getElementById('labelcomment'),
tooltip2 = document.getElementById('commenttooltip');

btn.addEventListener('click', () => {
  if (tooltip.style.display === "none") {
      tooltip.style.display = "block";
      tooltip1.style.display  = "none";
      tooltip2.style.display  = "none";
  }
  else{
    tooltip.style.display  = "none";
    
  }
})




btn1.addEventListener('click', () => {
  if (tooltip1.style.display === "none") {
      tooltip1.style.display = "block";
      tooltip.style.display  = "none";
      tooltip2.style.display  = "none";
  }
  else{
    tooltip1.style.display  = "none";
  }
})



btn2.addEventListener('click', () => {
  if (tooltip2.style.display === "none") {
      tooltip2.style.display = "block";
      tooltip1.style.display  = "none";
      tooltip.style.display  = "none";
  }
  else{
    tooltip2.style.display  = "none";
  }
})

</script>
