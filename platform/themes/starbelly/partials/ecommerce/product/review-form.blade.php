<form action="{{ route('public.reviews.create') }}" method="post" class="form-review-product sb-text mb-5">
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <div class="mb-3">
        <select name="star" id="sb-rating-bar">
            @foreach(range(1, 5) as $i)
                <option value="{{ $i }}"></option>
            @endforeach
        </select>
    </div>
    <div class="sb-group-input">
        <textarea name="comment" id="txt-comment" @guest('customer') disabled @endif required></textarea>
        <label>{{ __('Write your review') }}</label>
    </div>

    @auth('customer')
        <div>
            <script type="text/x-custom-template" id="review-image-template">
                <span class="image-viewer__item" data-id="__id__">
                <img src="{{ RvMedia::getDefaultImage() }}" alt="Preview" class="img-responsive d-block">
                <span class="image-viewer__icon-remove">
                    <i class="fi fi-rr-cross-circle"></i>
                </span>
            </span>
            </script>
            <div class="image-upload__viewer">
                <div class="image-viewer__list position-relative">
                    <div class="image-upload__uploader-container">
                        <div class="d-table">
                            <div class="image-upload__uploader">
                                <i class="fi fi-rr-file-add"></i>
                                <div class="image-upload__text">{{ __('Upload photos') }}</div>
                                <input
                                    type="file"
                                    name="images[]"
                                    data-max-files="{{ EcommerceHelper::reviewMaxFileNumber() }}"
                                    class="image-upload__file-input"
                                    accept="image/png,image/jpeg,image/jpg"
                                    multiple="multiple"
                                    data-max-size="{{ EcommerceHelper::reviewMaxFileSize(true) }}"
                                    data-max-size-message="{{ trans('validation.max.file', ['attribute' => '__attribute__', 'max' => '__max__']) }}"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="loading">
                        <div class="half-circle-spinner">
                            <div class="circle circle-1"></div>
                            <div class="circle circle-2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="help-block mt-2 mb-4">
                {{ __('You can upload up to :total photos, each photo maximum size is :max kilobytes', [
                    'total' => EcommerceHelper::reviewMaxFileNumber(),
                    'max' => EcommerceHelper::reviewMaxFileSize(true),
                ]) }}
            </div>
        </div>
    @else
        <p class="text-danger sb-text mb-3">{{ __('You need to log in to submit your review!') }}</p>
    @endauth

    <button type="submit" class="sb-btn sb-m-0" @guest('customer') disabled @endif>
        <span class="sb-icon">
            <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="{{ __('Submit Review') }}">
        </span>
        <span>{{ __('Submit Review') }}</span>
    </button>
</form>
