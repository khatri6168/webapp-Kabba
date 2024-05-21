{!! apply_filters('ecommerce_product_variation_form_start', null, $product) !!}
<div class="row price-group">
    <input type="hidden"
           value="{{ old('sale_type', $product ? $product->sale_type : 0) }}"
           class="detect-schedule hidden"
           name="sale_type">

    <div class="col-md-4">
        <div class="form-group mb-3 @if ($errors->has('sku')) has-error @endif">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.sku') }}</label>
            {!! Form::text('sku', old('sku', $product ? $product->sku : null), ['class' => 'next-input', 'id' => 'sku']) !!}
        </div>
        @if (($isVariation && !$product) || ($product && $product->is_variation && !$product->sku))
            <div class="form-group mb-3">
                <label class="text-title-field">
                    <input type="hidden" name="auto_generate_sku" value="0">
                    <input type="checkbox" name="auto_generate_sku" value="1">
                    &nbsp;{{ trans('plugins/ecommerce::products.form.auto_generate_sku') }}
                </label>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.price') }}</label>
            <div class="next-input--stylized">
                <span class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                <input name="price"
                       class="next-input input-mask-number regular-price next-input--invisible"
                       data-thousands-separator="{{ EcommerceHelper::getThousandSeparatorForInputMask() }}" data-decimal-separator="{{ EcommerceHelper::getDecimalSeparatorForInputMask() }}"
                       step="any"
                       value="{{ old('price', $product ? $product->price : ($originalProduct->price ?? 0)) }}"
                       type="text">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="text-title-field">
                <span>{{ trans('plugins/ecommerce::products.form.sale_price') }}</span>
                <a href="javascript:;"
                   class="turn-on-schedule @if (old('sale_type', $product ? $product->sale_type : ($originalProduct->sale_type ?? 0)) == 1) hidden @endif">{{ trans('plugins/ecommerce::products.form.choose_discount_period') }}</a>
                <a href="javascript:;"
                   class="turn-off-schedule @if (old('sale_type', $product ? $product->sale_type : ($originalProduct->sale_type ?? 0)) == 0) hidden @endif">{{ trans('plugins/ecommerce::products.form.cancel') }}</a>
            </label>
            <div class="next-input--stylized">
                <span class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                <input name="sale_price"
                       class="next-input input-mask-number sale-price next-input--invisible"
                       data-thousands-separator="{{ EcommerceHelper::getThousandSeparatorForInputMask() }}" data-decimal-separator="{{ EcommerceHelper::getDecimalSeparatorForInputMask() }}"
                       value="{{ old('sale_price', $product ? $product->sale_price : ($originalProduct->sale_price ?? null)) }}"
                       type="text">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.cost_per_item') }}</label>
                <div class="next-input--stylized">
                    <span class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                    <input name="cost_per_item"
                           class="next-input input-mask-number regular-price next-input--invisible"
                           step="any"
                           value="{{ old('cost_per_item', $product ? $product->cost_per_item : ($originalProduct->cost_per_item ?? 0)) }}"
                           type="text"
                           placeholder="{{ trans('plugins/ecommerce::products.form.cost_per_item_placeholder') }}">
                </div>
                {!! Form::helper(trans('plugins/ecommerce::products.form.cost_per_item_helper')) !!}
            </div>
        </div>
        <input type="hidden" value="{{ $product->id ?? null }}" name="product_id">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.barcode') }}</label>
                <div class="next-input--stylized">
                    <input name="barcode"
                           class="next-input next-input--invisible"
                           step="any"
                           value="{{ old('barcode', $product ? $product->barcode : ($originalProduct->barcode ?? null)) }}"
                           type="text"
                           placeholder="{{ trans('plugins/ecommerce::products.form.barcode_placeholder') }}">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 scheduled-time @if (old('sale_type', $product ? $product->sale_type : ($originalProduct->sale_type ?? 0)) == 0) hidden @endif">
        <div class="form-group mb-3">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.date.start') }}</label>
            <input name="start_date"
                   class="next-input form-date-time"
                   value="{{ old('start_date', $product ? $product->start_date : ($originalProduct->start_date ?? null)) }}"
                   type="text">
        </div>
    </div>
    <div class="col-md-6 scheduled-time @if (old('sale_type', $product ? $product->sale_type : ($originalProduct->sale_type ?? 0)) == 0) hidden @endif">
        <div class="form-group mb-3">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.date.end') }}</label>
            <input name="end_date"
                   class="next-input form-date-time"
                   value="{{ old('end_date', $product ? $product->end_date : ($originalProduct->end_date ?? null)) }}"
                   type="text">
        </div>
    </div>

    <div class="col-md-1" style="width: 140px;">
        <div class="form-group mb-3 mt-2">
            <label class="text-title-field text-center">
                <input type="checkbox" id="hour_track" value="{{ isset($product->hour_track)? 1 : 0 }}" name="hour_track" @if (isset($product->hour_track) && $product->hour_track == 1) checked @endif>
                &nbsp;{{ trans('plugins/ecommerce::products.hour_tracking') }}
            </label>
        </div>
    </div>
    <div class="col-md-2" style="width: 140px;">
        <select name="rental_type" id="rental_type" class="select2 form-control">
            <option value="0" @if (!isset($product->rental_type) || $product->rental_type == 0) selected @endif>No Rental</option>
            <option value="1" @if (isset($product->rental_type) && $product->rental_type == RENTAL_TYPE_DAILY) selected @endif>Daily</option>
            <option value="2" @if (isset($product->rental_type) && $product->rental_type == RENTAL_TYPE_WEEKEND) selected @endif>Weekend</option>
            <option value="3" @if (isset($product->rental_type) && $product->rental_type == RENTAL_TYPE_WEEKLY) selected @endif>Weekly</option>
            <option value="4" @if (isset($product->rental_type) && $product->rental_type == RENTAL_TYPE_MONTHLY) selected @endif>Monthly</option>
        </select>
    </div>
    <div class="col-md-2" style="width: 280px;">
        <div class="form-group mb-3">
            <div class="next-input--stylized no-border right-inner-addon input-container">
                <span class="next-input-add-on next-input__add-on--before" id="allocated_hours">8</span>
                <span style="width:200px">Number of Hours Allocated</span>
                <span title="{{ trans('plugins/ecommerce::products.hours_allocated_helper') }}"><i class="fa fa-info-circle color-blue-line-through"></i></span>
            </div>
        </div>
    </div>
    <div class="col-md-2" style="width: 120px;">
        <div class="form-group mb-3">
            <div class="next-input--stylized right-inner-addon input-container">
                <span class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                {!! Form::text('over_rate', old('prorate', $product ? $product->over_rate : null), ['class' => 'next-input input-mask-number-price regular-price next-input--invisible', 'id' => 'prorate', 'style' => 'min-width: 30px']) !!}
                <span title="Prorated Hourly Overage Cost"><i class="fa fa-info-circle color-blue-line-through"></i></span>
            </div>
        </div>
    </div>

</div>
<br>
<div class="form-group mb-3">
    <div class="equipment-management">
        <div class="">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.request_delivery_option') }}</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 mt-2" style="width: 80px;">
            @if(isset($product) && $product->delivery_pickup > 0 && $product->store_pickup > 0)
                <label><input type="checkbox" value="1" id="both" class="" {{(isset($product->delivery_pickup) && isset($product->store_pickup) && $product->delivery_pickup == 1 && $product->store_pickup == 1) ? 'checked' : '' }} >Both</label>
            @else
                <label><input type="checkbox" value="1" id="both" class="">Both</label>
            @endif
        </div>
        <div class="col-md-4 mt-2" style="width: 180px;">
            @if(isset($product) && $product->store_pickup > 0)
                <label><input type="checkbox" value="1" name="store_pickup" id="pickup" {{isset($product->store_pickup) && $product->store_pickup ? 'checked' : '' }} >{{ trans('plugins/ecommerce::products.in_store_pickup') }}</label>
            @else
                <label><input type="checkbox" value="1" name="store_pickup" id="pickup">{{ trans('plugins/ecommerce::products.in_store_pickup') }}</label>
            @endif
        </div>
        <div class="col-md-4 mt-2" style="width: 170px;">
            @if(isset($product) && $product->delivery_pickup > 0)
                <label><input type="checkbox" value="1" name="delivery_pickup" id="delivery" class="" {{isset($product->delivery_pickup) && $product->delivery_pickup ? 'checked' : '' }} >{{ trans('plugins/ecommerce::products.form.delivery_and_pick') }}</label>
            @else
                <label><input type="checkbox" value="1" name="delivery_pickup" id="delivery" class="">{{ trans('plugins/ecommerce::products.form.delivery_and_pick') }}</label>
            @endif
        </div>
        <div class="col-md-2" style="width: 120px">
            <div class="form-group mb-3">
                <div class="next-input--stylized">
                    <span class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                    {!! Form::text('delivery_price', old('delivery_price', $product ? $product->delivery_price : null), ['class' => 'input-mask-number-price regular-price next-input--invisible', 'id' => 'delivery_price', 'style' => 'width:40px;']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-2" style="width: 120px;">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.delivery_range') }}</label>
        </div>
        <div class="col-md-3" style="width:120px;">
            <div class="form-group mb-3">
                <div class="next-input--stylized">
                    <span class="next-input-add-on next-input__add-on--before">{{ trans('plugins/ecommerce::products.form.mile') }}</span>
                    {!! Form::text('delivery_range', old('delivery_range', $product ? $product->delivery_range : null), ['class' => 'input-mask-number-range regular-price next-input--invisible', 'id' => 'delivery_range', 'style' => 'width:40px;']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-2 " style="width: 120px;">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.distance') }}</label>
        </div>
    </div>
</div>

<hr/>

{!! apply_filters('ecommerce_product_variation_form_middle', null, $product) !!}

<div class="form-group mb-3">
    <div class="storehouse-management">
        <div class="mt5">
            <input type="hidden" name="with_storehouse_management" value="0">
            <label><input type="checkbox" class="storehouse-management-status" value="1" name="with_storehouse_management" @if (old('with_storehouse_management', $product ? $product->with_storehouse_management : ($originalProduct->with_storehouse_management ?? 0)) == 1) checked @endif> {{ trans('plugins/ecommerce::products.form.storehouse.storehouse') }}</label>
        </div>
    </div>
</div>
<div class="storehouse-info @if (old('with_storehouse_management', $product ? $product->with_storehouse_management : ($originalProduct->with_storehouse_management ?? 0)) == 0) hidden @endif">
    <div class="form-group mb-3">
        <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.storehouse.quantity') }}</label>
        <input type="text"
               class="next-input input-mask-number input-medium"
               value="{{ old('quantity', $product ? $product->quantity : ($originalProduct->quantity ?? 0)) }}"
               name="quantity">
    </div>
    <div class="form-group mb-3">
        <label class="text-title-field">
            <input type="hidden" name="allow_checkout_when_out_of_stock" value="0">
            <input type="checkbox" name="allow_checkout_when_out_of_stock" value="1"
                   @if (old('allow_checkout_when_out_of_stock', $product ? $product->allow_checkout_when_out_of_stock : ($originalProduct->allow_checkout_when_out_of_stock ?? 0)) == 1) checked @endif>
            &nbsp;{{ trans('plugins/ecommerce::products.form.stock.allow_order_when_out') }}
        </label>
    </div>
</div>

<div class="form-group stock-status-wrapper @if (old('with_storehouse_management', $product ? $product->with_storehouse_management : ($originalProduct->with_storehouse_management ?? 0)) == 1) hidden @endif">
    <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.stock_status') }}</label>
    {!! Form::customSelect('stock_status', \Botble\Ecommerce\Enums\StockStatusEnum::labels(), $product ? $product->stock_status : null) !!}
</div>

<hr/>

@if (!EcommerceHelper::isEnabledSupportDigitalProducts() ||
    (!$product && !$originalProduct && request()->input('product_type') != Botble\Ecommerce\Enums\ProductTypeEnum::DIGITAL) ||
    ($originalProduct && $originalProduct->isTypePhysical()) || ($product && $product->isTypePhysical()))
    <div class="shipping-management ">
        <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.shipping.title') }}</label>
        <div class="row">
            <div class="col-md-3 col-md-6">
                <div class="form-group mb-3">
                    <label>{{ trans('plugins/ecommerce::products.form.shipping.weight') }} ({{ ecommerce_weight_unit() }})</label>
                    <div class="next-input--stylized">
                        <span class="next-input-add-on next-input__add-on--before">{{ ecommerce_weight_unit() }}</span>
                        <input type="text" class="next-input input-mask-number next-input--invisible" name="weight" value="{{ old('weight', $product ? $product->weight : ($originalProduct->weight ?? 0)) }}">
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-6">
                <div class="form-group mb-3">
                    <label>{{ trans('plugins/ecommerce::products.form.shipping.length') }} ({{ ecommerce_width_height_unit() }})</label>
                    <div class="next-input--stylized">
                        <span class="next-input-add-on next-input__add-on--before">{{ ecommerce_width_height_unit() }}</span>
                        <input type="text" class="next-input input-mask-number next-input--invisible" name="length" value="{{ old('length', $product ? $product->length : ($originalProduct->length ?? 0)) }}">
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-6">
                <div class="form-group mb-3">
                    <label>{{ trans('plugins/ecommerce::products.form.shipping.wide') }} ({{ ecommerce_width_height_unit() }})</label>
                    <div class="next-input--stylized">
                        <span class="next-input-add-on next-input__add-on--before">{{ ecommerce_width_height_unit() }}</span>
                        <input type="text" class="next-input input-mask-number next-input--invisible" name="wide" value="{{ old('wide', $product ? $product->wide : ($originalProduct->wide ?? 0)) }}">
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-6">
                <div class="form-group mb-3">
                    <label>{{ trans('plugins/ecommerce::products.form.shipping.height') }} ({{ ecommerce_width_height_unit() }})</label>
                    <div class="next-input--stylized">
                        <span class="next-input-add-on next-input__add-on--before">{{ ecommerce_width_height_unit() }}</span>
                        <input type="text" class="next-input input-mask-number next-input--invisible" name="height" value="{{ old('height', $product ? $product->height : ($originalProduct->height ?? 0)) }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if (EcommerceHelper::isEnabledSupportDigitalProducts() &&
    ((!$product && !$originalProduct && request()->input('product_type') == Botble\Ecommerce\Enums\ProductTypeEnum::DIGITAL) ||
        ($originalProduct && $originalProduct->isTypeDigital()) ||
        ($product && $product->isTypeDigital())))
    <div class="mb-3 product-type-digital-management">
        <label for="product_file">{{ trans('plugins/ecommerce::products.digital_attachments.title') }}</label>
        <table class="table border">
            <thead>
            <tr>
                <th width="40"></th>
                <th>{{ trans('plugins/ecommerce::products.digital_attachments.file_name') }}</th>
                <th width="100">{{ trans('plugins/ecommerce::products.digital_attachments.file_size') }}</th>
                <th width="100">{{ trans('core/base::tables.created_at') }}</th>
                <th class="text-end" width="100"></th>
            </tr>
            </thead>
            <tbody>
            @if ($product)
                @foreach ($product->productFiles as $file)
                    <tr>
                        <td>
                            {!! Form::checkbox('product_files[' . $file->id . ']', 0, true, ['class' => 'd-none']) !!}
                            {!! Form::checkbox('product_files[' . $file->id . ']', $file->id, true, ['class' => 'digital-attachment-checkbox']) !!}
                        </td>
                        <td>
                            <div>
                                <i class="fas fa-paperclip"></i>
                                <span>{{ $file->basename }}</span>
                            </div>
                        </td>
                        <td>{{ BaseHelper::humanFileSize($file->file_size) }}</td>
                        <td>{{ BaseHelper::formatDate($file->created_at) }}</td>
                        <td class="text-end"></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <div class="digital_attachments_input">
            <input type="file" name="product_files_input[]" data-id="{{ Str::random(10) }}">
        </div>
        <div class="mt-2">
            <a href="#" class="digital_attachments_btn">{{ trans('plugins/ecommerce::products.digital_attachments.add') }}</a>
        </div>
    </div>
    <script type="text/x-custom-template" id="digital_attachment_template">
        <tr data-id="__id__">
            <td>
                <a class="text-danger remove-attachment-input"><i class="fas fa-minus-circle"></i></a>
            </td>
            <td>
                <i class="fas fa-paperclip"></i>
                <span>__file_name__</span>
            </td>
            <td>__file_size__</td>
            <td>-</td>
            <td class="text-end">
                <span class="text-warning">{{ trans('plugins/ecommerce::products.digital_attachments.unsaved') }}</span>
            </td>
        </tr>
    </script>
@endif
{!! apply_filters('ecommerce_product_variation_form_end', null, $product) !!}
<style>
    .no-border {
        border: none;
    }
    .right-inner-addon {
        position: relative;
    }
    .right-inner-addon input {
        padding-right: 35px !important;
    }
    .right-inner-addon i {
        position: absolute;
        right: 0px;
        padding: 12px 12px;
        pointer-events: none;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
<script>
    $(document).ready(function () {
        $('#hour_track').on('click', function() {
            if ($('#hour_track').prop('checked') == true) {
                $('#hour_track').val("1");
            } else {
                $('#hour_track').val("0");
            }
        });

        $('#rental_type').on('change', function () {
            if ($('#rental_type').val() == 0) {
                $('#allocated_hours').text('0');
            } else if ($('#rental_type').val() == 1) {
                $('#allocated_hours').text({{ get_ecommerce_setting('daily_hours') }});
            } else if ($('#rental_type').val() == 2) {
                $('#allocated_hours').text({{ get_ecommerce_setting('weekend_hours') }});
            } else if ($('#rental_type').val() == 3) {
                $('#allocated_hours').text({{ get_ecommerce_setting('weekly_hours') }});
            } else if ($('#rental_type').val() == 4) {
                $('#allocated_hours').text({{ get_ecommerce_setting('monthly_hours') }});
            }
        });

        $('#rental_type').trigger('change');

        setTimeout(() => {
            $('.input-mask-number-price').inputmask({
                alias: 'numeric',
                allowMinus: false,
                rightAlign: false,
                digits: 1,
                max: 999.9
            });

            $('.input-mask-number-range').inputmask({
                alias: 'numeric',
                allowMinus: false,
                rightAlign: false,
                max: 99
            });
        }, 2000);

        $('#both').on('change', function (ev) {
            if ($('#both').prop('checked') == true) {
                $('#delivery').prop('checked', true);
                $('#pickup').prop('checked', true);
            } else {
                $('#delivery').prop('checked', false);
                $('#pickup').prop('checked', false);
                $('#delivery_price').val(0);
            }
        });

        $('#delivery').on('change', function (ev) {
            if ($('#delivery').prop('checked') == false) {
                $('#both').prop('checked', false);
            } else {
                if ($('#pickup').prop('checked') == true) {
                    $('#both').prop('checked', true);
                } else {
                    $('#both').prop('checked', false);
                }
            }
        });

        $('#pickup').on('change', function (ev) {
            if ($('#pickup').prop('checked') == false) {
                $('#both').prop('checked', false);
            } else {
                if ($('#delivery').prop('checked') == true) {
                    $('#both').prop('checked', true);
                } else {
                    $('#both').prop('checked', false);
                }
            }
        });

        $('#pickup').on('change', function() {
            if ($('#pickup').prop('checked') == true) {
                $('#pickup').val("1");
            } else {
                $('#pickup').val("0");
            }
        });

        $('#delivery').on('change', function() {
            if ($('#delivery').prop('checked') == true) {
                $('#delivery').val("1");
            } else {
                $('#delivery').val("0");
                $('#delivery_price').val(0);
            }
        });
    });
</script>
