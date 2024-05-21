@php
    $isDefaultLanguage = ! defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME') ||
        ! request()->input('ref_lang') ||
        request()->input('ref_lang') == Language::getDefaultLocaleCode();
@endphp

@push('header')
    <script>
       
    </script>
@endpush

<div class="product-option-form-wrap">
    <div class="product-option-form-group">
        <div class="product-option-form-body">
            <input type="hidden" name="has_product_options" value="1">
            <div class="accordion" id="accordion-product-option"></div>
        </div>
        <div class="row">
            @if ($isDefaultLanguage)
                <div class="col-12 col-md-3">
                    @if(isset($data) && $data->id > 0)
                        <label><input type="checkbox" value="1" name="use_global" class="" {{isset($data->use_global) && $data->use_global ? 'checked' : '' }} > Use General Terms</label>
                    @else
                        <label><input type="checkbox" value="1" name="use_global" class=""> Use General Terms</label> 
                    @endif
                    
                </div>
                <div class="col-12 col-md-6">
                    @if(isset($data) && $data->id > 0)
                        <label><input type="checkbox" value="1" name="use_products_terms" id="use_products_terms" class="" {{isset($data->terms_id) && $data->terms_id ? 'checked' : ''}} > Combine Additional Product Specific Terms</label>
                    @else
                    <label><input type="checkbox" value="1" name="use_products_terms" id="use_products_terms" class="" disabled > Combine Additional Product Specific Terms</label>
                    @endif
                </div>
                <div class="col-12 col-md-3 d-flex justify-content-end">
                    @if(isset($data) && $data->id > 0 && isset($data->terms_id) && $data->terms_id)
                        <div class="ui-select-wrapper d-inline-block global-option-div hide" style="width: 200px;">
                    @else
                        <div class="ui-select-wrapper d-inline-block global-option-div hide" style="width: 200px; display: none !important;">
                    @endif
                    
                        <select id="global-option1" class="form-control ui-select" name="terms_id">
                            <option
                                value="">Select Terms</option>
                            @foreach($terms as $id => $name)
                                <option value="{{ $id }}" {{isset($data) && $data->terms_id == $id ? 'selected' : ''}}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <svg class="svg-next-icon svg-next-icon-size-16">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path></svg>
                        </svg>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<script>
    $(document).ready(function($) {
        $(document).on('change', '#use_products_terms', function(event) {
            if($(this).is(":checked")){
                $(".global-option-div").attr("style", "width: 200px; display: block !important");
            } else {
               // $("#global-option").val('');
                $(".global-option-div").attr("style", "width: 200px; display: none !important");
            }
        }); 
        
        if($('input[name="use_global"]').is(":checked")){
            $('input[name="use_products_terms"]').removeAttr('disabled');
        }
        $('input[name="use_global"]').click(function(){
            if($('input[name="use_global"]').is(":checked")){
                $('input[name="use_products_terms"]').removeAttr('disabled');
            }else{
                $('#use_products_terms').attr('disabled','disabled');
                $('#use_products_terms').prop('checked', false);
                $(".global-option-div").attr("style", "width: 200px; display: none !important");
                $('#global-option1 option').removeAttr("selected", "selected")
            }
        })

        $('input[name="use_products_terms"]').click(function(){
            if($('input[name="use_products_terms"]').is(":checked")){

            }else{
                $('#global-option1 option').removeAttr("selected", "selected")
                //$("#global-option1").prop('selectedIndex', 0);
            }

        })

    });
</script>


