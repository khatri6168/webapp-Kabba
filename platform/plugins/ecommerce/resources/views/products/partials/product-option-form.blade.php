@php
    $product = $product->loadMissing(['options' => function ($query) {
        return $query->with(['values']);
    }]);
    $oldOption = old('options', []) ?? [];
    $currentProductOption = $product->options;
    foreach ($currentProductOption as $key => $option) {
        $currentProductOption[$key]['name'] = $option->name;
        foreach ($option['values'] as $valueKey => $value) {
            $currentProductOption[$key]['values'][$valueKey]['option_value'] = $value->option_value;
        }
    }

    if (!empty($oldOption)) {
        $currentProductOption = $oldOption;
    }

    $isDefaultLanguage = ! defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME') ||
        ! request()->input('ref_lang') ||
        request()->input('ref_lang') == Language::getDefaultLocaleCode();
@endphp

@push('header')
    <script>
        window.productOptions = {
            productOptionLang: {!! Js::from(trans('plugins/ecommerce::product-option')) !!},
            coreBaseLang: {!! Js::from(trans('core/base::forms')) !!},
            currentProductOption: {!! Js::from($currentProductOption) !!},
            options: {!! Js::from($options) !!},
            routes: {!! Js::from($routes) !!},
            isDefaultLanguage: {{ (int)$isDefaultLanguage }}
        }
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
                <div class="col-12 col-md-6">
                    <button type="button" class="btn btn-info add-new-option"
                            id="add-new-option">{{ trans('plugins/ecommerce::product-option.add_new_option') }}</button>
                </div>
                @if (count($globalOptions))
                
                    <div class="col-12 col-md-6 d-flex justify-content-end">
                        <div class="ui-select-wrapper d-inline-block" style="width: 200px;">
                            <select id="global-option" class="form-control ui-select">
                                <option
                                    value="-1">{{ trans('plugins/ecommerce::product-option.select_global_option') }}</option>
                                @foreach($globalOptions as $option)
                                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                                @endforeach
                            </select>
                            <svg class="svg-next-icon svg-next-icon-size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path></svg>
                            </svg>
                        </div>
                        <button type="button" role="button" class="btn btn-info add-from-global-option ms-3">{{ trans('plugins/ecommerce::product-option.add_global_option') }}</button>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
<x-core-base::modal
    id="comment-modal"
    :title="trans('Comment')"
    button-id="save-comment-button"
    button-type="button"
    :button-label="trans('submit')"
    size="lg">
    <label for="comment-text">Comment</label>
    <input type="hidden" id="comment-id"/>
    <textarea class="form-control" name="comment-text" id="comment-text" rows="4"></textarea>

</x-core-base::modal>

<script id="template-option-values-of-field" type="text/x-custom-template">
    <table class="table table-bordered setting-option mt-3">
        <thead>
        <tr>
            <th scope="col">__priceLabel__</th>
            @if ($isDefaultLanguage)
                <th scope="col" colspan="2">__priceTypeLabel__</th>
            @endif
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="number" name="options[__index__][values][0][affect_price]" class="form-control option-label" value="__affectPrice__" placeholder="__affectPriceLabel__"/>
                </td>
                @if ($isDefaultLanguage)
                    <td>
                        <select class="form-select" name="options[__index__][values][0][affect_type]">
                            <option value="0" __selectedFixed__> __fixedLang__</option>
                            <option value="1" __selectedPercent__> __percentLang__</option>
                        </select>
                    </td>
                @endif
            </tr>
        </tbody>
    </table>
</script>
<script id="template-option-type-array" type="text/x-custom-template">
    <table class="table table-bordered setting-option mt-3">
        <thead>
        <tr class="option-row">
            @if ($isDefaultLanguage)
                <th scope="col">#</th>
            @endif
            <th scope="col">__label__</th>
            @if ($isDefaultLanguage)
                <th scope="col">__priceLabel__</th>
                <th scope="col" colspan="2">__priceTypeLabel__</th>
            @endif
        </tr>
        </thead>
        <tbody>
            __optionValue__
        </tbody>
    </table>
</script>

<script id="template-option-type-value" type="text/x-custom-template">
    <tr data-index="__key__">
        @if ($isDefaultLanguage)
            <td>
                <i class="fa fa-sort"></i>
                <input type="hidden" class="option-value-order" value="__order__" name="options[__index__][values][__key__][order]">
            </td>
        @endif
        <td>
            <input type="hidden" class="option-value-order" value="__id__" name="options[__index__][values][__key__][id]">
            <input type="text" name="options[__index__][values][__key__][option_value]" class="form-control option-label" value="__option_value_input__" placeholder="__labelPlaceholder__" />
        </td>
        @if ($isDefaultLanguage)
            <td>
                <input type="number" name="options[__index__][values][__key__][affect_price]" class="form-control affect_price" value="__affectPrice__" placeholder="__affectPriceLabel__" />
            </td>
            <td>
                <select class="form-select affect_type" name="options[__index__][values][__key__][affect_type]">
                    <option value="0" __selectedFixed__> __fixedLang__ </option>
                    <option value="1" __selectedPercent__> __percentLang__ </option>
                </select>
            </td>
            <td style="width: 50px;">
                <button class="btn btn-default remove-row"><i class="fa fa-trash"></i></button>
            </td>
        @endif
    </tr>
</script>
<script id="template-option-type-array-rental" type="text/x-custom-template">
    <table class="table table-bordered setting-option mt-3">
        <thead>
        <tr class="option-row">
            @if ($isDefaultLanguage)
                <th scope="col">#</th>
            @endif
            <th scope="col">__label__</th>
            @if ($isDefaultLanguage)
                <th scope="col">__priceLabel__</th>
                <th scope="col" class="rental-div" >__valueTypeLabel__</th>
                <th scope="col" class="rental-div">__commentLabel__</th>
                <th scope="col" colspan="2">__priceTypeLabel__</th>
            @endif
        </tr>
        </thead>
        <tbody>
            __optionValue__
        </tbody>
    </table>
</script>

<script id="template-option-type-value-rental" type="text/x-custom-template">
    <tr data-index="__key__">
        @if ($isDefaultLanguage)
            <td>
                <i class="fa fa-sort"></i>
                <input type="hidden" class="option-value-order" value="__order__" name="options[__index__][values][__key__][order]">
            </td>
        @endif
        <td>
            <input type="hidden" class="option-value-order" value="__id__" name="options[__index__][values][__key__][id]">
            <input type="text" name="options[__index__][values][__key__][option_value]" class="form-control option-label" value="__option_value_input__" placeholder="__labelPlaceholder__" />
        </td>
        @if ($isDefaultLanguage)
            <td>
                <input type="number" name="options[__index__][values][__key__][affect_price]" class="form-control affect_price" value="__affectPrice__" placeholder="__affectPriceLabel__" />
            </td>
            <td class="rental-div">
                <select class="form-select value_type" name="options[__index__][values][__key__][value_type]">
                    <option value="0" __selectedBlank__>__blank__</option>
                    <option value="1" __selectedChecked__>__checked__</option>
                </select>
            </td>
             <td class="rental-div">
                <button class="btn btn-success comment-btn add-comment" data-value="__commentValue__" type="button" data-key="__index_____key__">__addComment__</button>
                <input type="hidden" class="form-control hidden-comment" id="comment___index_____key__" name="options[__index__][values][__key__][comment]" value="__commentValue__"/>
            </td>
            <td>
                <select class="form-select affect_type" name="options[__index__][values][__key__][affect_type]">
                    <option value="0" __selectedFixed__> __fixedLang__ </option>
                    <option value="1" __selectedPercent__> __percentLang__ </option>
                </select>
            </td>
            <td style="width: 50px;">
                <button class="btn btn-default remove-row"><i class="fa fa-trash"></i></button>
            </td>
        @endif
    </tr>
</script>

<script id="template-option" type="text/x-custom-template">
    <div class="accordion-item mb-3" data-index="__index__" data-product-option-index="__index__">
        <input type="hidden" name="options[__index__][id]" value="__id__" />
        <input type="hidden" class="option-order" name="options[__index__][order]" value="__order__" />
        <h2 class="accordion-header" id="product-option-__index__">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-product-option-__index__" aria-expanded="true" aria-controls="product-option-__index__">
                __optionName__
            </button>
        </h2>
        <div id="collapse-product-option-__index__" class="accordion-collapse collapse-product-option show" aria-labelledby="product-option-__id__" data-bs-parent="#accordion-product-option">
            <div class="accordion-body">
                <div class="row">
                    <div class="col">
                        <label class="form-label" for="">__nameLabel__</label>
                        <input type="text" name="options[__index__][name]" class="form-control option-name" value="__option_name__" placeholder="__namePlaceHolder__">
                    </div>
                    @if ($isDefaultLanguage)
                        <div class="col">
                            <label class="form-label" for="">__optionTypeLabel__</label>
                            <select name="options[__index__][option_type]" id="" class="form-control option-type">
                                __optionTypeOption__
                            </select>
                        </div>
                        <div class="col" style="margin-top: 38px;">
                            <label for="" class="form-label">&nbsp;</label>
                            <input class="option-required" name="options[__index__][required]" id="required-__index__" __checked__ type="checkbox">
                            <label for="required-__index__">__requiredLabel__</label>
                        </div>
                        <div class="col pt-4">
                            <button type="button" data-index="__index__" role="button" class="remove-option float-end btn btn-default">
                            <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="option-value-wrapper option-value-sortable">
                    __optionValueSortable__
                </div>
            </div>
        </div>
    </div>
</script>
<script>
    'use strict'
    $(document).ready(function() {
        const { productOptionLang, coreBaseLang, currentProductOption, options } = window.productOptions
        let productOptionForm = {
            productOptions: currentProductOption,
            init() {
                this.eventListeners()
                this.generateProductOption()
                this.sortable()
            },
            sortable() {
                $('.option-value-sortable tbody').sortable({
                    stop: function() {
                        let idsInOrder = $('.option-value-sortable tbody').sortable('toArray', { attribute: 'data-index' })
                        idsInOrder.map(function(id, index) {
                            $('.option-row[data-index="' + id + '"]').find('.option-value-order').val(index)
                        })
                    },
                })

                $('.accordion-product-option').sortable({
                    stop: function() {
                        let idsInOrder = $('.accordion-product-option').sortable('toArray', { attribute: 'data-index' })
                        idsInOrder.map(function(id, index) {
                            $('.accordion-item[data-index="' + id + '"]').find('.option-order').val(index)
                        })
                    },
                })

            },
            generateProductOption() {
                let self = this
                let html = ''
                this.productOptions.map(function(item, index) {
                    html += self.generateOptionTemplate(item, index)
                })
                $('#accordion-product-option').html(html)
                this.sortable()
            },
            eventListeners() {
                let self = this
                $('.product-option-form-wrap')
                    .on('click', '.add-from-global-option', function() {
                        let selectedOption = $('#global-option').val()
                        if (selectedOption != -1) {
                            self.addFromGlobalOption(selectedOption)
                        } else {
                            toastr.error(productOptionLang.please_select_option)
                        }

                        return false
                    })
                    .on('click', '.remove-option', function() {
                        const index = $(this).data('index')
                        self.productOptions.splice(index, 1)
                        $(this).parents('.accordion-item').remove()
                    })
                    .on('keyup', '.option-name', function() {
                        const index = $(this).parents('.accordion-item').data('product-option-index')
                        const name = $(this).val()
                        $(this).parents('.accordion-item').find('.accordion-button').text(name)
                        self.productOptions[index].name = name
                    })

                    .on('change', '.option-type', function() {
                        const index = $(this).parents('.accordion-item').data('product-option-index')
                        self.productOptions[index].option_type = $(this).val()
                        self.generateProductOption()
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

                    .on('change', '.option-required', function() {
                        const index = $(this).parents('.accordion-item').data('product-option-index')
                        self.productOptions[index].required = $(this).is(':checked')
                    })

                    .on('click', '.add-new-row', function() {
                        self.addNewRow($(this))
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

                    .on('click', '.remove-row', function() {
                        $(this).parent().parent().remove()
                    })

                    .on('click', '.add-new-option', function() {
                        const option = {
                            name: '',
                            values: [{
                                affect_price: 0,
                                affect_type: 0,
                            }],
                            option_type: 'N/A',
                            required: false,
                        }

                        self.productOptions.push(option)

                        const html = self.generateOptionTemplate(option, self.productOptions.length - 1)
                        $('#accordion-product-option').append(html)

                        self.sortable()
                    })
            },
            addNewRow(element) {
                let table = element.parent().find('table tbody')
                let index = element.parents('.accordion-item').data('product-option-index')
                let tr = table.find('tr').last().clone()
                let labelName = 'options[' + index + '][values][' + table.find('tr').length + '][option_value]',
                    affectName = 'options[' + index + '][values][' + table.find('tr').length + '][affect_price]',
                    affectTypeName = 'options[' + index + '][values][' + table.find('tr').length + '][affect_type]',
                    value_type = 'options[' + index + '][values][' + table.find('tr').length + '][value_type]',
                    hidden_comment = 'options[' + index + '][values][' + table.find('tr').length + '][comment]',
                    count = index+'_'+table.find('tr').length
                tr.find('.option-label').prop('name', labelName).val('')
                tr.find('.affect_price').prop('name', affectName).val(0)
                tr.find('.affect_type').prop('name', affectTypeName).val(0)
                tr.find('.option-value-order').val(table.find('tr').length)
                tr.attr('data-index', table.find('tr').length)
                tr.find('.value_type').attr('name', value_type);
                tr.find('.hidden-comment').attr('name', hidden_comment).attr('id', 'comment_' + count);
                tr.find('.comment-btn').attr('data-key', count);
                table.append(tr)
            },
            addFromGlobalOption(optionId) {
                let self = this
                axios
                    .get(window.productOptions.routes.ajax_option_info + '?id=' + optionId)
                    .then(function(res) {
                        const data = res.data.data

                        const option = {
                            id: data.id,
                            name: data.name,
                            option_type: data.option_type,
                            option_value: data.option_value,
                            values: data.values,
                            required: data.required,
                        }

                        self.productOptions.push(option)

                        const html = self.generateOptionTemplate(option, self.productOptions.length - 1)

                        $('#accordion-product-option').append(html)
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
            },
            generateOptionTemplate(option, index) {
                let options = this.generateFieldOptions(option)
                let id = typeof option.id !== 'undefined' ? option.id : 0
                const order = typeof option.order !== 'undefined' && option.order != 9999 ? option.order : index
                const template = $('#template-option').html()
                const checked = (option.required) ? 'checked' : ''
                const values = this.generateOptionValues(option.values, option.option_type, index)
                return template.replace(/__index__/g, index)
                    .replace(/__order__/g, order)
                    .replace(/__id__/g, id)
                    .replace(/__optionName__/g, '#' + (parseInt(index) + 1) + ' ' + option.name)
                    .replace(/__nameLabel__/g, coreBaseLang.name)
                    .replace(/__option_name__/g, option.name)
                    .replace(/__namePlaceHolder__/g, coreBaseLang.name_placeholder)
                    .replace(/__optionTypeLabel__/g, productOptionLang.option_type)
                    .replace(/__optionTypeOption__/g, options)
                    .replace(/__checked__/g, checked)
                    .replace(/__requiredLabel__/g, productOptionLang.required)
                    .replace(/__optionValueSortable__/g, values)
            },
            generateFieldOptions(option) {
                let html = ''
                $.each(options, function(key, value) {
                    if (typeof value == 'object') {
                        html += '<optgroup label="' + key + '">'
                        $.each(value, function(option_key, option_value) {
                            const option_checked = (option.option_type === option_key) ? 'selected' : ''
                            html += '<option ' + option_checked + ' value="' + option_key + '">' + option_value + '</option>'
                        })
                        html += '</optgroup>'
                    } else {
                        const option_checked = (option.option_type === key) ? 'selected' : ''
                        html += '<option ' + option_checked + ' value="' + key + '">' + value + '</option>'
                    }
                })

                return html
            },
            generateOptionValues(values, type = '', index) {
                let label = productOptionLang.label,
                    price = productOptionLang.price,
                    priceType = productOptionLang.price_type,
                    template = '',
                    html = ''
                let optionType = type.split('\\')
                optionType = optionType[optionType.length - 1]
                if (optionType !== '' && typeof type !== 'undefined' && type !== 'N/A') {
                    /*if(optionType == "Rental"){
                        $(".rental-div").show();
                    } else {
                        $(".rental-div").hide();
                        $(".value_type").val(0);
                        $(".hidden-comment").val("");
                        $(".comment-btn").text("{{ trans('Add Comment') }}").addClass('add-comment').removeClass('edit-comment').addClass('btn-success').removeClass('btn-info');
                    }*/
                    if (optionType === 'Field') {
                        template = $('#template-option-values-of-field').html()
                        const selectedFixed = (values[0].affect_type === 0) ? 'selected' : ''
                        const selectedPercent = (values[0].affect_type === 1) ? 'selected' : ''
                        html += template.replace(/__priceLabel__/g, price)
                            .replace(/__priceTypeLabel__/g, priceType)
                            .replace(/__id__/g, values[0].id)
                            .replace(/__index__/g, index)
                            .replace(/__affectPrice__/g, values[0].affect_price)
                            .replace(/__affectPriceLabel__/g, productOptionLang.affect_price_label)
                            .replace(/__selectedFixed__/g, selectedFixed)
                            .replace(/__fixedLang__/g, productOptionLang.fixed)
                            .replace(/__selectedPercent__/g, selectedPercent)
                            .replace(/__percentLang__/g, productOptionLang.percent)
                            .replace(/__valueTypeLabel__/g, 'Value')
                            
                    } else if(optionType === 'Rental'){
                        if (values.length > 0) {
                        const template = $('#template-option-type-array-rental').html()
                            let valuesResult = ''
                            const tmp = template.replace(/__priceLabel__/g, price)
                                .replace(/__priceTypeLabel__/g, priceType)
                                .replace(/__valueTypeLabel__/g, 'Value')
                                .replace(/__commentLabel__/g, 'Comment')
                                .replace(/__index__/g, index)
                                .replace(/__label__/g, label)
                            $.each(values, function(key, value) {
                                const valueTemplate = $('#template-option-type-value-rental').html()
                                const order = typeof value.order === 'undefined' ? value.order : key
                                const selectedFixed = (value.affect_type === 0) ? 'selected' : ''
                                const selectedPercent = (value.affect_type === 1) ? 'selected' : ''
                                const selectedBlank = (value.value_type === 0) ? 'selected' : ''
                                const selectedChecked = (value.value_type === 1) ? 'selected' : ''
                                const commentButtonText = (value.comment != '') ? 'Edit Comment' : 'Add Comment'
                                const commentButtonClass = (value.comment != '') ? 'edit-comment' : 'add-comment'
                                
                                valuesResult += valueTemplate
                                    .replace(/__key__/g, key)
                                    .replace(/__id__/g, value.id)
                                    .replace(/__order__/g, order)
                                    .replace(/__index__/g, index)
                                    .replace(/__labelPlaceholder__/g, productOptionLang.label_placeholder)
                                    .replace(/__affectPriceLabel__/g, productOptionLang.affect_price_label)
                                    .replace(/__selectedFixed__/g, selectedFixed)
                                    .replace(/__fixedLang__/g, productOptionLang.fixed)
                                    .replace(/__selectedPercent__/g, selectedPercent)
                                    .replace(/__option_value_input__/g, value.option_value ? value.option_value : '')
                                    .replace(/__affectPrice__/g, value.affect_price)
                                    .replace(/__percentLang__/g, productOptionLang.percent)
                                    .replace(/__selectedBlank__/g, selectedBlank)
                                    .replace(/__selectedChecked__/g, selectedChecked)
                                    .replace(/__commentValue__/g, value.comment)
                                    .replace(/__addComment__/g, commentButtonText)
                                    .replace(/add-comment/g, commentButtonClass)
                                    .replace(/__blank__/g, 'Blank')
                                    .replace(/__checked__/g, 'Checked')
                            })
                            html += tmp.replace(/__optionValue__/g, valuesResult)
                        }
                        html += `<button type="button" class="btn btn-info mt-3 add-new-row" id="add-new-row">${productOptionLang.add_new_row}</button>`
                    } else {
                        if (values.length > 0) {
                            const template = $('#template-option-type-array').html()
                            let valuesResult = ''
                            const tmp = template.replace(/__priceLabel__/g, price)
                                .replace(/__priceTypeLabel__/g, priceType)
                                .replace(/__index__/g, index)
                                .replace(/__label__/g, label)
                            $.each(values, function(key, value) {
                                const valueTemplate = $('#template-option-type-value').html()
                                const order = typeof value.order === 'undefined' ? value.order : key
                                const selectedFixed = (value.affect_type === 0) ? 'selected' : ''
                                const selectedPercent = (value.affect_type === 1) ? 'selected' : ''
                                valuesResult += valueTemplate
                                    .replace(/__key__/g, key)
                                    .replace(/__id__/g, value.id)
                                    .replace(/__order__/g, order)
                                    .replace(/__index__/g, index)
                                    .replace(/__labelPlaceholder__/g, productOptionLang.label_placeholder)
                                    .replace(/__affectPriceLabel__/g, productOptionLang.affect_price_label)
                                    .replace(/__selectedFixed__/g, selectedFixed)
                                    .replace(/__fixedLang__/g, productOptionLang.fixed)
                                    .replace(/__selectedPercent__/g, selectedPercent)
                                    .replace(/__option_value_input__/g, value.option_value ? value.option_value : '')
                                    .replace(/__affectPrice__/g, value.affect_price)
                                    .replace(/__percentLang__/g, productOptionLang.percent)
                            })
                            html += tmp.replace(/__optionValue__/g, valuesResult)
                        }
                        html += `<button type="button" class="btn btn-info mt-3 add-new-row" id="add-new-row">${productOptionLang.add_new_row}</button>`
                    }
                }
                return html
            },
        }
        productOptionForm.init()
    })
    $(document).ready(function($) {
        $('#save-comment-button').removeAttr("type").attr("type", "button");
        $(document).on('click', '.add-comment', function(event) {
            $("#comment-text").val("");
            $("#comment-id").val($(this).data('key'));
            $('#comment-modal').modal('show');
        });
        $(document).on('click', '.edit-comment', function(event) {
            var key = $(this).data('key');
            if ($("#comment_"+key).val() != undefined) {
                $("#comment-text").val($("#comment_"+key).val());
            }
            $("#comment-id").val(key);
            $('#comment-modal').modal('show');
        });
        $(document).on('click', '#save-comment-button', function(event) {
            var key = $("#comment-id").val();
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
        $(document).on('click', '.add-from-global-option', function(event) {
             
        }); 
    });

</script>
