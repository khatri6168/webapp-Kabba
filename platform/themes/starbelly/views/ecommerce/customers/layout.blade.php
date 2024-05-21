<section class="sb-p-90-90 sb-text crop-avatar">
    <div class="container" data-sticky-container="">
        <div class="row">
            @include(Theme::getThemeNamespace('views.ecommerce.customers.sidebar'))
            <div class="col-lg-9">
                <div class="customer-tab">
                    <div class="sb-mb-30">
                        <h3>{{ SeoHelper::getTitle() }}</h3>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="avatar-modal-label"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="avatar-form" method="post" action="{{ route('customer.avatar') }}" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title" id="avatar-modal-label">
                            <strong>{{ __('Profile Image') }}</strong>
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="avatar-body">
                            <div class="avatar-upload">
                                <input class="avatar-src" name="avatar_src" type="hidden">
                                <input class="avatar-data" name="avatar_data" type="hidden">
                                @csrf
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <label for="avatarInput">{{ __('New image') }}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input class="avatar-input form-control" id="avatarInput" name="avatar_file" type="file" style="margin-left: 0">
                                    </div>
                                </div>
                            </div>
                            <div class="loading" tabindex="-1" role="img" aria-label="{{ __('Loading') }}"></div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="avatar-wrapper"></div>
                                    <div class="error-message text-danger" style="display: none"></div>
                                </div>
                                <div class="col-md-3 avatar-preview-wrapper">
                                    <div class="avatar-preview preview-lg"></div>
                                    <div class="avatar-preview preview-md"></div>
                                    <div class="avatar-preview preview-sm"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button class="btn btn-primary avatar-save" type="submit">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

