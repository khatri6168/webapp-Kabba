<div class="table-actions">
    {!! $extra !!}
    @if (!empty($edit))
        @if (Auth::user()->hasPermission($edit))
            @if (empty($item->comment))
                <a href="{{ route($edit, $item->id) }}" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-original-title="{{ trans('core/base::tables.edit') }}"><i class="fa fa-edit"></i></a>
            @else
                <a href="{{ route($edit, $item->id) }}" class="btn btn-icon btn-sm" data-bs-toggle="tooltip" style="margin-bottom: 0px; margin-right:2px; padding-top: 0px; padding-left:6px;" data-bs-original-title="{{ trans('core/base::tables.edit') }}"><img height='32px' src='/vendor/core/plugins/ecommerce/images/diary-icon.svg' alt='icon'></a>
            @endif
        @endif
    @endif

    @if (!empty($delete))
        @if (Auth::user()->hasPermission($delete))
            <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog" data-bs-toggle="tooltip" data-section="{{ route($delete, $item->id) }}" role="button" data-bs-original-title="{{ trans('core/base::tables.delete_entry') }}" >
                <i class="fa fa-trash"></i>
            </a>
        @endif
    @endif
</div>
