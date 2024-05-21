<div class="modal fade" id="confirm-delete-modal" tabindex="-1" aria-labelledby="confirm-delete-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirm-delete-modal-label">{{ __('Confirm delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Do you really want to delete this address?') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary border-0 py-2" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary py-2 mb-0 avatar-save btn-confirm-delete">{{ __('Delete') }}</button>
            </div>
        </div>
    </div>
</div>
