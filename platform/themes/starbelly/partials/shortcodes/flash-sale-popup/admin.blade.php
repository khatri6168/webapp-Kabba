@php
    $flashSaleIds = explode(',', Arr::get($attributes, 'flash_sale_ids'));
@endphp

<div class="form-group">
    <label class="control-label">{{ __('Choose flash sale') }}</label>
    <select class="select-full" name="flash_sale_ids" multiple>
        @foreach($flashSales as $flashSale)
            <option @selected(in_array($flashSale->id, $flashSaleIds)) value="{{ $flashSale->id }}">{{ $flashSale->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="title" class="form-label">{{ __('Description') }}</label>
    <input type="text" id="description" name="description" class="form-control" value="{{ Arr::get($attributes, 'description') }}">
</div>

<div class="form-group">
    <label for="title" class="form-label">{{ __('Timeout to display popup (Second)') }}</label>
    <input type="number" id="timeout" name="timeout" class="form-control" value="{{ Arr::get($attributes, 'timeout') ?? 5 }}">
</div>
