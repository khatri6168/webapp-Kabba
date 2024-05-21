<div class="main-form">
    <form method="POST" action="{{ route('deliveries.edit', $delivery->id) }}" accept-charset="UTF-8"
          id="botble-ecommerce-forms-delivery-pick-up-form" class="js-base-form dirty-check" novalidate="novalidate">
        <input type="hidden" value="{{$delivery->id}}" name="id">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="delivery_date" class="control-label required" aria-required="true">Delivery Date</label>
                        <div class="input-group datepicker">
                            <input class="form-control flatpickr-input" placeholder="M d, Y"
                                   data-date-format="M d, Y" v-pre="" data-input="" name="delivery_date"
                                   type="text" value="{{ $delivery->delivery_date }}" id="delivery_date" aria-invalid="false"
                                   aria-describedby="delivery_date-error" {{ $readonly == true ? 'disabled': '' }}>
                            <a class="input-button" title="toggle" data-toggle="">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     viewBox="0 0 17 17">
                                    <g></g>
                                    <path
                                        d="M14 2V1h-3v1H6V1H3v1H0v15h17V2h-3zM12 2h1v2h-1V2zM4 2h1v2H4V2zM16 16H1v-8.921h15V16zM1 6.079v-3.079h2v2h3V3h5v2h3V3h2v3.079H1z"></path>
                                </svg>
                            </a>
                            <a class="input-button text-danger" title="clear" data-clear="">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 17 17">
                                    <g></g>
                                    <path
                                        d="M9.207 8.5l6.646 6.646-.707.707L8.5 9.207l-6.646 6.646-.707-.707L7.793 8.5 1.146 1.854l.707-.707L8.5 7.793l6.646-6.646.707.707L9.207 8.5z"></path>
                                </svg>
                            </a>
                        </div>
                        <span id="delivery_date-error" class="invalid-feedback" style="display: inline;"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="delivery_time" class="control-label required" aria-required="true">Time</label>
                        <div class="input-group">
                            <input class="form-control  time-picker timepicker timepicker-24" placeholder="Delivery Time"
                                   v-pre=""
                                   name="delivery_time" type="text" value="{{ $delivery->delivery_time }}" id="delivery_time"
                                {{ $readonly == true ? 'disabled': '' }}>
                            <span class="input-group-text">
                                <button class="btn default" type="button">
                                    <i class="fa fa-clock"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="status" class="control-label required" aria-required="true">Status</label>
                        <div class="input-group">
                            <div class="ui-select-wrapper form-group" style="width: 100%;">
                                <select class="form-control ui-select is-valid" v-pre="" id="delivery_status" name="delivery_status"
                                        @if($delivery->pickup_status == \Botble\Ecommerce\Enums\DeliveryStatusEnum::COMPLETED) disabled @endif
                                        aria-invalid="false" aria-describedby="delivery_status-error">
                                    <option value="1" @if($delivery->delivery_status == \Botble\Ecommerce\Enums\DeliveryStatusEnum::PENDING) selected @endif>Pending</option>
                                    <option value="2" @if($delivery->delivery_status == \Botble\Ecommerce\Enums\DeliveryStatusEnum::COMPLETED) selected @endif>Completed</option>
                                </select>
                                <span id="delivery_status-error" class="invalid-feedback" style="display: inline;"></span>
                                <svg class="svg-next-icon svg-next-icon-size-16">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path></svg>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="pickup_date" class="control-label required" aria-required="true">Pick Up Date</label>
                        <div class="input-group datepicker">
                            <input class="form-control flatpickr-input" placeholder="M d, Y"
                                   data-date-format="M d, Y"
                                   v-pre="" data-input="" name="pickup_date" type="text"
                                   value="{{ $delivery->pickup_date }}"
                                   id="pickup_date" aria-invalid="false" aria-describedby="pickup_date-error"
                                    {{ $readonly == true ? 'disabled': '' }}>
                            <a class="input-button" title="toggle" data-toggle="">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     viewBox="0 0 17 17">
                                    <g></g>
                                    <path
                                        d="M14 2V1h-3v1H6V1H3v1H0v15h17V2h-3zM12 2h1v2h-1V2zM4 2h1v2H4V2zM16 16H1v-8.921h15V16zM1 6.079v-3.079h2v2h3V3h5v2h3V3h2v3.079H1z"></path>
                                </svg>
                            </a>
                            <a class="input-button text-danger" title="clear" data-clear="">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 17 17">
                                    <g></g>
                                    <path
                                        d="M9.207 8.5l6.646 6.646-.707.707L8.5 9.207l-6.646 6.646-.707-.707L7.793 8.5 1.146 1.854l.707-.707L8.5 7.793l6.646-6.646.707.707L9.207 8.5z"></path>
                                </svg>
                            </a>
                        </div>
                        <span id="pickup_date-error" class="invalid-feedback" style="display: inline;"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="pickup_time" class="control-label required" aria-required="true">Time</label>
                        <div class="input-group">
                            <input class="form-control time-picker timepicker timepicker-24"
                                   placeholder="Pick Up Time"
                                   v-pre="" name="pickup_time" type="text" value="{{ $delivery->pickup_time }}" id="pickup_time"
                                   aria-invalid="false"
                                   aria-describedby="pickup_time-error"
                                {{ $readonly == true ? 'disabled': '' }}>
                            <span class="input-group-text">
                        <button class="btn default" type="button">
                            <i class="fa fa-clock"></i>
                        </button>
                    </span>
                        </div>
                        <span id="pickup_time-error" class="invalid-feedback" style="display: inline;"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="pickup_status" class="control-label required" aria-required="true">Status</label>
                        <div class="input-group">
                            <div class="ui-select-wrapper form-group" style="width: 100%;">
                                <select class="form-control ui-select" @if($delivery->delivery_status == \Botble\Ecommerce\Enums\DeliveryStatusEnum::PENDING) disabled @endif v-pre="" id="pickup_status" name="pickup_status">
                                    <option value="1" @if($delivery->pickup_status == \Botble\Ecommerce\Enums\DeliveryStatusEnum::PENDING) selected @endif>Pending</option>
                                    <option value="2" @if($delivery->pickup_status == \Botble\Ecommerce\Enums\DeliveryStatusEnum::COMPLETED) selected @endif>Completed</option>
                                </select>
                                <svg class="svg-next-icon svg-next-icon-size-16">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path></svg>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

