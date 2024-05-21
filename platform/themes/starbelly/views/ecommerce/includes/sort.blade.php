@if ($sortParams = EcommerceHelper::getSortParams())
    @php
        $sortBy = request()->input('sort-by');
        if ($sortBy && Arr::has($sortParams, $sortBy)) {
            $sortByLabel = Arr::get($sortParams, $sortBy);
        } else {
            $sortByLabel = Arr::first($sortParams);
        }
    @endphp

    <div @class(['catalog-toolbar__ordering align-items-center gap-2', 'd-flex' => $products->count(), 'd-none' => ! $products->count()])>
        <input type="hidden" name="sort-by" value="{{ BaseHelper::stringify(request()->input('sort-by')) }}">
        <div class="text d-none d-lg-block">{{ __('Sort by') }}</div>
        <div class="dropdown">
            <button class="sb-dropdown btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ $sortByLabel }}
            </button>
            <ul class="dropdown-menu">
                @foreach ($sortParams as $key => $name)
                    <li @class(['active' => request()->input('sort-by') === $key])>
                        <a class="dropdown-item" href="#" data-value="{{ $key }}">{{ $name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
