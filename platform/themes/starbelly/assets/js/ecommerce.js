import { getCookie, handleError, setCookie, showError, showSuccess } from './utils'

'use strict'

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
})

let Ecommerce = Ecommerce || {}

window.Ecommerce = Ecommerce;

(function($) {
    const Loading = $('#loading')
    Ecommerce.$body = $(document.body)
    Ecommerce.$formSearch = $('#products-filter-form')
    Ecommerce.productListing = '.products-listing'
    Ecommerce.$productListing = $(Ecommerce.productListing)
    let isReadySubmitTrigger = true

    Ecommerce.init = function() {
        this.addProductToCart()
        this.addProductToWishlist()
        this.addProductToCompare()
        this.submitReviewProduct()
        this.customerDashboard()
        this.removeCartItem()
        this.loadAjaxCart()
        this.productQuantity()
        this.applyCouponCode()
        this.filterSlider()
        this.productsFilter()
        this.removeCompareItem()
        this.removeWishlistItem()

        const $ratingBar = $('#sb-rating-bar')
        if ($ratingBar.length) {
            $ratingBar.barrating({
                initialRating: 5,
                theme: 'css-stars',
            })
        }

        $(document).ready(function() {
            let $modal = $('#flash-sale-modal')
            if ($modal.length && !getCookie($modal.data('id'))) {
                setTimeout(function() {
                    $modal.addClass('sb-active')
                    setCookie($modal.data('id'), 1, 1)
                }, 5000)
            }

            $('.sb-close-popup , .sb-ppc').on('click', function() {
                $('.sb-popup-frame').removeClass('sb-active')
            })
        })

        window.onBeforeChangeSwatches = function(data, $attrs) {
            const $product = $attrs.closest('.product-details')
            const $form = $product.find('.cart-form')

            $product.find('.error-message').hide()
            $product.find('.success-message').hide()
            $product.find('.number-items-available').html('').hide()
            const $submit = $form.find('button[type=submit]')
            $submit.addClass('button-loading')

            if (data && data.attributes) {
                $submit.prop('disabled', true)
            }
        }

        window.onChangeSwatchesSuccess = function(res, $attrs) {
            const $product = $attrs.closest('.product-details')
            const $form = $product.find('.cart-form')
            const $footerCartForm = $('.footer-cart-form')
            $product.find('.error-message').hide()
            $product.find('.success-message').hide()            
            if (res) {
                let $submit = $form.find('button[type=submit]')
                $submit.removeClass('button-loading')
                if (res.error) {
                    $submit.prop('disabled', true)
                    $product.find('.number-items-available').html('<span class="text-danger">(' + res.message + ')</span>').show()
                    $form.find('.hidden-product-id').val('')
                    $footerCartForm.find('.hidden-product-id').val('')
                } else {
                    const data = res.data
                    const $price = $product.find('.box-price')
                    const $salePrice = $price.find('.price')
                    const $originalPrice = $price.find('.price-old')

                    if (data.sale_price !== data.price) {
                        $originalPrice.removeClass('d-none')
                    } else {
                        $originalPrice.addClass('d-none')
                    }

                    $salePrice.text(data.display_sale_price)
                    $originalPrice.text(data.display_price)

                    if (data.sku) {
                        $product.find('.meta-sku .meta-value').text(data.sku)
                        $product.find('.meta-sku').removeClass('d-none')
                    } else {
                        $product.find('.meta-sku').addClass('d-none')
                    }

                    $form.find('.hidden-product-id').val(data.id)
                    $footerCartForm.find('.hidden-product-id').val(data.id)
                    $submit.prop('disabled', false)

                    if (data.error_message) {
                        $submit.prop('disabled', true)
                        $product.find('.number-items-available').html('<span class="text-danger">(' + data.error_message + ')</span>').show()
                    } else if (data.success_message) {
                        $product.find('.number-items-available').html(res.data.stock_status_html).show()
                    } else {
                        $product.find('.number-items-available').html('').hide()
                    }

                    const unavailableAttributeIds = data.unavailable_attribute_ids || []
                    $product.find('.attribute-swatch-item').removeClass('pe-none')
                    $product.find('.product-filter-item option').prop('disabled', false)
                    if (unavailableAttributeIds && unavailableAttributeIds.length) {
                        unavailableAttributeIds.map(function(id) {
                            let $item = $product.find('.attribute-swatch-item[data-id="' + id + '"]')
                            if ($item.length) {
                                $item.addClass('pe-none')
                                $item.find('input').prop('checked', false)
                            } else {
                                $item = $product.find('.product-filter-item option[data-id="' + id + '"]')
                                if ($item.length) {
                                    $item.prop('disabled', 'disabled').prop('selected', false)
                                }
                            }
                        })
                    }
                }
            }
        }
    }

    Ecommerce.customerDashboard = function() {
        if ($.fn.datepicker) {
            $('#date_of_birth').datepicker({
                format: 'yyyy-mm-dd',
                orientation: 'bottom',
            })
        }

        $('#avatar').on('change', event => {
            let input = event.currentTarget
            if (input.files && input.files[0]) {
                let reader = new FileReader()
                reader.onload = e => {
                    $('.userpic-avatar')
                        .attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0])
            }
        })

        $(document).on('click', '.btn-trigger-delete-address', function(event) {
            event.preventDefault()
            $('.btn-confirm-delete').data('url', $(this).data('url'))
            $('#confirm-delete-modal').modal('show')
        })

        $(document).on('click', '.btn-confirm-delete', function(event) {
            event.preventDefault()
            let $current = $(this)
            $.ajax({
                url: $current.data('url'),
                type: 'GET',
                beforeSend: () => {
                    $current.addClass('loading')
                },
                success: res => {
                    $current.closest('.modal').modal('hide')
                    if (res.error) {
                        showError(res.message)
                    } else {
                        showSuccess(res.message)
                        $('.btn-trigger-delete-address[data-url="' + $current.data('url') + '"]').closest('.col-md-6').remove()
                    }
                },
                error: res => {
                    handleError(res)
                },
                complete: () => {
                    $current.removeClass('loading')
                },
            })
        })
    }

    Ecommerce.addProductToWishlist = function() {
        Ecommerce.$body.on('click', '.product-wishlist-button', function(e) {
            e.preventDefault()
            const $btn = $(e.currentTarget)

            $.ajax({
                url: $btn.data('url'),
                method: 'POST',
                beforeSend: () => {
                    $btn.addClass('button-loading')
                },
                success: res => {
                    if (res.error) {
                        showError(res.message)
                        return false
                    }

                    showSuccess(res.message)
                    $('.btn-wishlist .header-item-counter').text(res.data.count)
                    showSuccess(res.message)
                    if (!$('.sb-btn-wishlist').find('.sb-wishlist-number').length) {
                        $('.sb-btn-wishlist').load(window.siteUrl + ' .sb-btn-wishlist > *', function() {
                        })
                    } else {
                        $('.sb-top-bar-frame').find('.sb-wishlist-number').text(res.data.count)
                    }
                    if (res.data?.added) {
                        $(
                            '.wishlist-button .wishlist[data-url="' + $btn.data('url') + '"]',
                        ).addClass('added-to-wishlist')
                    } else {
                        $('.wishlist-button .wishlist[data-url="' + $btn.data('url') + '"]').removeClass('added-to-wishlist')
                    }
                },
                error: res => {
                    showError(res.message)
                },
                complete: () => {
                    $btn.removeClass('button-loading')
                },
            })
        })
    }

    Ecommerce.addProductToCompare = function() {
        Ecommerce.$body.on('click', '.product-compare-button', function(e) {
            e.preventDefault()
            const $btn = $(e.currentTarget)

            $.ajax({
                url: $btn.data('url'),
                method: 'POST',
                beforeSend: () => {
                    $btn.addClass('button-loading')
                },
                success: res => {
                    if (res.error) {
                        showError(res.message)
                        return false
                    }
                    showSuccess(res.message)
                    $('.header-top .compare-counter').text(res.data.count)
                },
                error: res => {
                    showError(res.message)
                },
                complete: () => {
                    $btn.removeClass('button-loading')
                },
            })
        })
    }

    Ecommerce.addProductToCart = function() {
        Ecommerce.$body.on('click', 'form.cart-form button[type=submit]', function(e) {
            e.preventDefault()
            const $form = $(this).closest('form.cart-form')
            const $btn = $(this)

            $btn.find('.sb-icon img').hide()
            $btn.find('.sb-icon i').show()

            $.ajax({
                type: 'POST',
                url: $form.prop('action'),
                data: $form.serialize(),
                success: res => {
                    if (res.error) {
                        showError(res.message)
                        return
                    }

                    console.log(res.data.content);
                    let rawId = "";
                    $.each(res.data.content, (indexInArray, valueOfElement) =>{
                        console.log(valueOfElement['id']);
                        if (valueOfElement['id'] == res.data.product_id){
                            rawId = valueOfElement['rowId'];
                        }
                    });
                    var currentUrl = window.location.href;
                    var url = new URL(currentUrl);
                    url.searchParams.set("rawId", rawId);
                    var newUrl = url.href;
                    console.log(newUrl);
                    window.history.pushState(null, document.title, newUrl);
                    $('.hidden-raw-id').val(rawId);
                    showSuccess(res.message)

                    Ecommerce.loadAjaxCart($btn)

                    if ($btn.prop('name') === 'checkout' && res.data.next_url !== undefined) {
                        window.location.href = res.data.next_url
                    }
                    $('.rawId').val('');
                },
                error: res => {
                    handleError(res, $form)
                },
                complete: () => {
                    $btn.find('.sb-icon img').show()
                    $btn.find('.sb-icon i').hide()
                    console.log('here');
                },
            })
        })
    }

    Ecommerce.removeCompareItem = function() {
        $(document).on('click', '.remove-compare-item', function(event) {
            event.preventDefault()
            const _self = $(this)
            $.ajax({
                url: _self.data('url'),
                method: 'POST',
                data: {
                    _method: 'DELETE',
                },
                beforeSend: function beforeSend() {
                    Loading.show()
                },
                success: function success(res) {
                    if (res.error) {
                        showError(res.message)
                    } else {
                        showSuccess(res.message)
                        $('.header-top .compare-counter').text(res.data.count)
                        $('.compare-page-content').load(window.location.href + ' .compare-page-content > *')
                    }
                },
                error: function error(res) {
                    showError(res.message)
                },
                complete: function complete() {
                    Loading.hide()
                },
            })
        })
    }

    Ecommerce.submitReviewProduct = function() {
        let imagesReviewBuffer = []
        let setImagesFormReview = function(input) {
            const dT = new ClipboardEvent('').clipboardData || // Firefox < 62 workaround exploiting https://bugzilla.mozilla.org/show_bug.cgi?id=1422655
                new DataTransfer() // specs compliant (as of March 2018 only Chrome)
            for (let file of imagesReviewBuffer) {
                dT.items.add(file)
            }
            input.files = dT.files
            loadPreviewImage(input)
        }

        let loadPreviewImage = function(input) {
            let $uploadText = $('.image-upload__text')
            const maxFiles = $(input).data('max-files')
            let filesAmount = input.files.length

            if (maxFiles) {
                if (filesAmount >= maxFiles) {
                    $uploadText.closest('.image-upload__uploader-container').addClass('d-none')
                } else {
                    $uploadText.closest('.image-upload__uploader-container').removeClass('d-none')
                }
                $uploadText.text(filesAmount + '/' + maxFiles)
            } else {
                $uploadText.text(filesAmount)
            }
            const viewerList = $('.image-viewer__list')
            const $template = $('#review-image-template').html()

            viewerList.addClass('is-loading')
            viewerList.find('.image-viewer__item').remove()

            if (filesAmount) {
                for (let i = filesAmount - 1; i >= 0; i--) {
                    viewerList.prepend($template.replace('__id__', i))
                }
                for (let j = filesAmount - 1; j >= 0; j--) {
                    let reader = new FileReader()
                    reader.onload = function(event) {
                        viewerList
                            .find('.image-viewer__item[data-id=' + j + ']')
                            .find('img')
                            .attr('src', event.target.result)
                    }
                    reader.readAsDataURL(input.files[j])
                }
            }
            viewerList.removeClass('is-loading')
        }

        $(document).on('change', '.form-review-product input[type=file]', function(event) {
            event.preventDefault()
            let input = this
            let $input = $(input)
            let maxSize = $input.data('max-size')
            Object.keys(input.files).map(function(i) {
                if (maxSize && (input.files[i].size / 1024) > maxSize) {
                    let message = $input.data('max-size-message')
                        .replace('__attribute__', input.files[i].name)
                        .replace('__max__', maxSize)
                    showError(message)
                } else {
                    imagesReviewBuffer.push(input.files[i])
                }
            })

            let filesAmount = imagesReviewBuffer.length
            const maxFiles = $input.data('max-files')
            if (maxFiles && filesAmount > maxFiles) {
                imagesReviewBuffer.splice(filesAmount - maxFiles - 1, filesAmount - maxFiles)
            }

            setImagesFormReview(input)
        })

        $(document).on('click', '.form-review-product .image-viewer__icon-remove', function(event) {
            event.preventDefault()
            const $this = $(event.currentTarget)
            let id = $this.closest('.image-viewer__item').data('id')
            imagesReviewBuffer.splice(id, 1)

            let input = $('.form-review-product input[type=file]')[0]
            setImagesFormReview(input)
        })

        $(document).on('click', '.form-review-product button[type=submit]', function(e) {
            e.preventDefault()
            e.stopPropagation()
            const $this = $(e.currentTarget)

            const $form = $(this).closest('form')
            $.ajax({
                type: 'POST',
                cache: false,
                url: $form.prop('action'),
                data: new FormData($form[0]),
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $this.prop('disabled', true)
                },
                success: res => {
                    if (!res.error) {
                        $form.find('select').val(0)
                        $form.find('textarea').val('')

                        showSuccess(res.message)

                        setTimeout(function() {
                            window.location.reload()
                        }, 1500)
                    } else {
                        showError(res.message)
                    }
                },
                error: res => {
                    handleError(res, $form)
                },
                complete: () => {
                    $this.prop('disabled', false)
                },
            })
        })
        Ecommerce.productQuantity = function() {
            Ecommerce.$body.on(
                'click',
                '.quantity .increase, .quantity .decrease',
                function(e) {
                    e.preventDefault()
                    let $this = $(this),
                        $qty = $this.siblings('.qty'),
                        step = parseInt($qty.attr('step'), 10),
                        current = parseInt($qty.val(), 10),
                        min = parseInt($qty.attr('min'), 10),
                        max = parseInt($qty.attr('max'), 10)
                    min = min || 1
                    max = max || current + 1
                    if ($this.hasClass('decrease') && current > min) {
                        $qty.val(current - step)
                        $qty.trigger('change')
                    }
                    if ($this.hasClass('increase') && current < max) {
                        $qty.val(current + step)
                        $qty.trigger('change')
                    }

                    Ecommerce.processUpdateCart($this)
                },
            )
            Ecommerce.$body.on('keyup', '.quantity .qty', function(e) {
                e.preventDefault()
                let $this = $(this),
                    $wrapperBtn = $this.closest('.product-button'),
                    $btn = $wrapperBtn.find('.quantity_button'),
                    $price = $this
                        .closest('.quantity')
                        .siblings('.box-price')
                        .find('.price-current'),
                    $priceFirst = $price.data('current'),
                    current = parseInt($this.val(), 10),
                    min = parseInt($this.attr('min'), 10),
                    max = parseInt($this.attr('max'), 10)
                let min_check = min ? min : 1
                let max_check = max ? max : current + 1
                if (current <= max_check && current >= min_check) {
                    $btn.attr('data-quantity', current)
                    let $total = ($priceFirst * current).toFixed(2)
                    $price.html($total)
                }

                Ecommerce.processUpdateCart($this)
            })
        }
        Ecommerce.processUpdateCart = function($this) {
            const $form = $('.cart-page-content').find('.form--shopping-cart')

            if (!$form.length) {
                return false
            }

            $.ajax({
                type: 'POST',
                cache: false,
                url: $form.prop('action'),
                data: new FormData($form[0]),
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $('#loading').show()
                },
                success: res => {
                    if (res.error) {
                        showError(res.message)
                        return false
                    }

                    $('.cart-page-content').load(window.siteConfig.cartUrl + ' .cart-page-content > *')

                    Ecommerce.loadAjaxCart()

                    showSuccess(res.message)
                },
                error: res => {
                    $this.closest('.ps-table--shopping-cart').removeClass('content-loading')
                    handleError(res)
                },
                complete: () => {
                    $('#loading').hide()
                },
            })
        }
        Ecommerce.removeCartItem = function() {
            $(document).on('click', '.remove-cart-item', function(event) {
                event.preventDefault()
                let _self = $(this)

                let _item = _self.closest('.sb-cart-item')

                $.ajax({
                    url: _self.data('url'),
                    method: 'GET',
                    beforeSend: () => {
                        Loading.show()
                        _item.fadeOut(1000)
                    },
                    success: res => {
                        if (res.error) {
                            showSuccess(res.message)
                            return false
                        }

                        const $cartContent = $('.cart-page-content')

                        if ($cartContent.length && window.siteConfig?.cartUrl) {
                            $cartContent.load(window.siteConfig.cartUrl + ' .cart-page-content > *', function() {
                            })
                        }

                        _item.remove()
                        Ecommerce.loadAjaxCart()
                    },
                    error: res => {
                        handleError(res)
                        _item.fadeIn()
                    },
                    complete: () => {
                        Loading.hide()
                    },
                })
            })
        }
        Ecommerce.loadAjaxCart = function($element = null) {
            if (window.siteConfig?.ajaxCart) {
                $.ajax({
                    url: window.siteConfig.ajaxCart,
                    method: 'GET',
                    success: function(res) {
                        if (!res.error) {
                            const $cartNumber = $('.sb-top-bar-frame').find('.sb-cart-number')
                            $('.btn-shopping-cart .header-item-counter').text(res.data.count)
                            $('.cart--mini .cart-price-total .cart-amount span').text(res.data.total_price)
                            $('.menu--footer .icon-cart .cart-counter').text(res.data.count)
                            $cartNumber.text(res.data.count)
                            $('.sb-minicart').html(res.data.html)
                            $('.sb-minicart').addClass('sb-active')

                            $cartNumber.addClass('sb-added')
                            if ($element) {
                                $element.addClass('sb-added')
                            }
                            setTimeout(() => {
                                $cartNumber.removeClass('sb-added')
                                if ($element) {
                                    $element.removeClass('sb-added')
                                }
                            }, 600)
                        }
                    },
                })
            }
        }

        Ecommerce.applyCouponCode = function() {
            $(document).on('keypress', '.form-coupon-wrapper .coupon-code', e => {
                if (e.key !== 'Enter') {
                    return
                }

                e.preventDefault()
                e.stopPropagation()
                $(e.currentTarget).closest('.form-coupon-wrapper').find('.btn-apply-coupon-code').trigger('click')
            })

            $(document).on('click', '.btn-apply-coupon-code', e => {
                e.preventDefault()
                let _self = $(e.currentTarget)

                $.ajax({
                    url: _self.data('url'),
                    type: 'POST',
                    data: {
                        coupon_code: _self.closest('.form-coupon-wrapper').find('.coupon-code').val(),
                    },
                    beforeSend: () => {
                        Loading.show()
                    },
                    success: res => {
                        if (!res.error) {
                            $('.cart-page-content').load(window.location.href + '?applied_coupon=1 .cart-page-content > *', function() {
                                _self.prop('disabled', false).removeClass('loading')
                                showSuccess(res.message)
                            })
                        } else {
                            showError(res.message)
                        }
                    },
                    error: data => {
                        Loading.hide()
                        handleError(data)
                    },
                    complete: res => {
                        Loading.hide()
                        if (!(res.status === 200 && res?.responseJSON?.error === false)) {
                        }
                    },
                })
            })

            $(document).on('click', '.btn-remove-coupon-code', e => {
                e.preventDefault()
                const _self = $(e.currentTarget)
                const buttonText = _self.text()
                _self.text(_self.data('processing-text'))

                $.ajax({
                    url: _self.data('url'),
                    type: 'POST',
                    beforeSend: () => {
                        Loading.show()
                    },
                    success: res => {
                        if (!res.error) {
                            $('.cart-page-content').load(window.location.href + ' .cart-page-content > *', function() {
                                _self.text(buttonText)
                            })
                        } else {
                            showSuccess(res.message)
                        }
                    },
                    error: (res) => {
                        Loading.hide()
                        handleError(res)
                    },
                    complete: res => {
                        Loading.hide()
                        if (!(res.status === 200 && res?.responseJSON?.error === false)) {
                            _self.text(buttonText)
                        }
                    },
                })
            })
        }
    }

    Ecommerce.filterSlider = function() {
        $('.nonlinear').each(function(index, element) {
            let $element = $(element)
            let min = $element.data('min')
            let max = $element.data('max')
            let $wrapper = $(element).closest('.nonlinear-wrapper')
            noUiSlider.create(element, {
                connect: true,
                behaviour: 'tap',
                start: [
                    $wrapper.find('.product-filter-item-price-0').val(),
                    $wrapper.find('.product-filter-item-price-1').val(),
                ],
                range: {
                    min: min,
                    '10%': max * 0.1,
                    '20%': max * 0.2,
                    '30%': max * 0.3,
                    '40%': max * 0.4,
                    '50%': max * 0.5,
                    '60%': max * 0.6,
                    '70%': max * 0.7,
                    '80%': max * 0.8,
                    '90%': max * 0.9,
                    max: max,
                },
            })

            let nodes = [
                $wrapper.find('.slider__min'),
                $wrapper.find('.slider__max'),
            ]

            element.noUiSlider.on('update', function(values, handle) {
                nodes[handle].html(Ecommerce.numberFormat(values[handle]))
            })

            element.noUiSlider.on('change', function(values, handle) {
                $wrapper
                    .find('.product-filter-item-price-' + handle)
                    .val(Math.round(values[handle]))
                    .trigger('change')
            })
        })
    }

    Ecommerce.numberFormat = function(number, decimals, dec_point, thousands_sep) {
        let n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = typeof thousands_sep === 'undefined' ? ',' : thousands_sep,
            dec = typeof dec_point === 'undefined' ? '.' : dec_point,
            toFixedFix = function(n, prec) {
                // Fix for IE parseFloat(0.55).toFixed(0) = 0
                let k = Math.pow(10, prec)
                return Math.round(n * k) / k
            },
            s = (prec ? toFixedFix(n, prec) : Math.round(n))
                .toString()
                .split('.')

        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
        }

        if ((s[1] || '').length < prec) {
            s[1] = s[1] || ''
            s[1] += new Array(prec - s[1].length + 1).join('0')
        }
        return s.join(dec)
    }

    Ecommerce.$body.on('click', '.sidebar-filter-mobile', function(e) {
        e.preventDefault()
        Ecommerce.toggleSidebarFilterProducts('open', $(e.currentTarget).data('toggle'))
    })

    Ecommerce.$body.on('click', '.catalog-sidebar .backdrop, #cart-mobile .backdrop', function(e) {
        e.preventDefault()
        $(this).parent().removeClass('active')
    })

    $(document).on('click', '.close-toggle--sidebar', function(e) {
        e.preventDefault()
        let $panel

        if ($(this).data('toggle-closest')) {
            $panel = $(this).closest($(this).data('toggle-closest'))
        }

        if (!$panel || !$panel.length) {
            $panel = $(this).closest('.panel--sidebar')
        }

        $panel.removeClass('active')
    })

    Ecommerce.toggleSidebarFilterProducts = function(status = 'close', target = 'product-categories-primary-sidebar') {
        const $el = $('[data-toggle-target="' + target + '"]')

        if (status === 'close') {
            $el.removeClass('active')
        } else {
            $el.addClass('active')
        }
    }

    Ecommerce.$body.on('click', '.catalog-toolbar__ordering .dropdown .dropdown-menu a', function(e) {
        e.preventDefault()
        const $this = $(e.currentTarget)
        const $parent = $this.closest('.dropdown')
        $parent.find('li').removeClass('active')
        $this.closest('li').addClass('active')
        $parent.find('button[data-bs-toggle=dropdown').html($this.html())
        $this.closest('.catalog-toolbar__ordering').find('input[name=sort-by]').val($this.data('value')).trigger('change')
    })

    $('.catalog-toolbar__ordering input[name=sort-by]').on('change', function(e) {
        Ecommerce.$formSearch.find('input[name=sort-by]').val($(e.currentTarget).val())
        Ecommerce.$formSearch.trigger('submit')
    })

    Ecommerce.convertFromDataToArray = function(formData) {
        let data = []
        formData.forEach(function(obj) {
            if (obj.value) {
                // break with price
                if (['min_price', 'max_price'].includes(obj.name)) {
                    const dataValue = Ecommerce.$formSearch
                        .find('input[name=' + obj.name + ']')
                        .data(obj.name.substring(0, 3))
                    if (dataValue === parseInt(obj.value)) {
                        return
                    }
                }
                data.push(obj)
            }
        })
        return data
    }

    Ecommerce.productsFilter = function() {
        Ecommerce.widgetProductCategories = '.widget-product-categories'
        Ecommerce.$widgetProductCategories = $(Ecommerce.widgetProductCategories)

        $(document).on('change', '#products-filter-form .product-filter-item', function() {
            if (isReadySubmitTrigger) {
                $(this).closest('form').trigger('submit')
            }
        })

        function openCategoryFilter($li) {
            if ($li.length) {
                $li.addClass('opened')
                if ($li.closest('ul').closest('li.category-filter').length) {
                    openCategoryFilter($li.closest('ul').closest('li.category-filter'))
                }
            }
        }

        const $categories = $('.widget-product-categories').find('li a.active')
        $categories.map(function(e, i) {
            const $parent = $(i).closest('li.category-filter').closest('ul').closest('li.category-filter')
            if ($parent.length) {
                openCategoryFilter($parent)
            }
        })

        $('.catalog-toolbar__ordering input[name=sort-by]').on('change', function(e) {
            Ecommerce.$formSearch.find('input[name=sort-by]').val($(e.currentTarget).val())
            Ecommerce.$formSearch.trigger('submit')
        })

        Ecommerce.$body.on('click', '.toggle-menu', function(e) {
            e.preventDefault()
            $(this).closest('li').toggleClass('opened')
        })

        $(document).on('click', Ecommerce.widgetProductCategories + ' li a', function(e) {
            e.preventDefault()
            const $this = $(e.currentTarget)
            const activated = $this.hasClass('active')
            const $parent = $this.closest(Ecommerce.widgetProductCategories)
            $parent.find('li a').removeClass('active')
            $this.addClass('active')

            const $input = $parent.find('input[name=\'categories[]\']')
            if ($input.length) {
                if (activated) {
                    $this.removeClass('active')
                    $input.val('')
                } else {
                    $input.val($this.data('id'))
                }
                $input.trigger('change')
            } else {
                let href = $this.attr('href')
                Ecommerce.$formSearch.attr('action', href).trigger('submit')
            }
        })

        $(document).on('submit', '#products-filter-form', function(e) {
            e.preventDefault()

            const $form = $(e.currentTarget)
            const formData = $form.serializeArray()
            let data = Ecommerce.convertFromDataToArray(formData)
            let uriData = []

            // Paginate
            const $elPage = Ecommerce.$productListing.find('input[name=page]')
            if ($elPage.val()) {
                data.push({ name: 'page', value: $elPage.val() })
            }

            // Without "s" param
            data.map(function(obj) {
                uriData.push(encodeURIComponent(obj.name) + '=' + obj.value)
            })

            const nextHref =
                $form.attr('action') +
                (uriData && uriData.length ? '?' + uriData.join('&') : '')

            // add to params get to popstate not show json
            data.push({ name: '_', value: +new Date() })

            $.ajax({
                url: $form.attr('action'),
                type: 'GET',
                data: data,
                beforeSend: function() {
                    // Show loading before sending
                    Ecommerce.$productListing.find('.loading').show()
                    // Animation scroll to filter button
                    $('html, body').animate({ scrollTop: Ecommerce.$productListing.offset().top - 200 }, 500)
                    // Change price step
                    const priceStep = Ecommerce.$formSearch.find('.nonlinear')
                    if (priceStep.length) {
                        priceStep[0].noUiSlider.set([
                            Ecommerce.$formSearch
                                .find('input[name=min_price]')
                                .val(),
                            Ecommerce.$formSearch
                                .find('input[name=max_price]')
                                .val(),
                        ])
                    }
                    Ecommerce.toggleSidebarFilterProducts()
                },
                success: function(res) {
                    if (res.error === false) {
                        Ecommerce.$productListing.html(res.data)

                        const total = res.message
                        const $productsFound = $('.products-found')
                        if (total && $productsFound.length) {
                            $productsFound.html('<span class="text-primary me-1">' + total.substr(0, total.indexOf(' ')) +
                                '</span>' + total.substr(total.indexOf(' ') + 1))
                        }

                        if (!$('.products-listing .sb-menu-item').length) {
                            $('.catalog-toolbar__ordering').addClass('d-none').removeClass('d-flex')
                        } else {
                            $('.catalog-toolbar__ordering').addClass('d-flex').removeClass('d-none')
                        }

                        $('.product-found-text').text(res.message)

                        if (res.additional?.category_tree) {
                            $('.widget-product-categories .widget-layered-nav-list').html(res.additional?.category_tree)
                        }

                        if (res.additional?.breadcrumb) {
                            $('.page-breadcrumbs div').html(res.additional.breadcrumb)
                        }

                        if (nextHref !== window.location.href) {
                            window.history.pushState(data, res.message, nextHref)
                        }
                    } else {
                        Ecommerce.showError(res.message || 'Opp!')
                    }
                },
                error: function(res) {
                    Ecommerce.handleError(res)
                },
                complete: function() {
                    Ecommerce.$productListing.find('.loading').hide()
                },
            })
        })

        $(document).on('click', Ecommerce.productListing + ' .sb-pagination a', function(e) {
            e.preventDefault()
            let url = new URL($(e.currentTarget).attr('href'))
            let page = url.searchParams.get('page')
            Ecommerce.$productListing.find('input[name=page]').val(page)
            Ecommerce.$formSearch.trigger('submit')
        })
    }

    Ecommerce.changeInputInSearchForm = function(parseParams) {
        isReadySubmitTrigger = false
        Ecommerce.$formSearch
            .find('input, select, textarea')
            .each(function(e, i) {
                const $el = $(i)
                const name = $el.attr('name')
                let value = parseParams[name] || null
                const type = $el.attr('type')
                switch (type) {
                    case 'checkbox':
                        $el.prop('checked', false)
                        if (Array.isArray(value)) {
                            $el.prop('checked', value.includes($el.val()))
                        } else {
                            $el.prop('checked', !!value)
                        }
                        break
                    default:
                        if ($el.is('[name=max_price]')) {
                            $el.val(value || $el.data('max'))
                        } else if ($el.is('[name=min_price]')) {
                            $el.val(value || $el.data('min'))
                        } else if ($el.val() !== value) {
                            $el.val(value)
                        }
                        break
                }
            })
        isReadySubmitTrigger = true
    }


    Ecommerce.parseParamsSearch = function(query, includeArray = false) {
        let pairs = query || window.location.search.substring(1)
        let re = /([^&=]+)=?([^&]*)/g
        let decodeRE = /\+/g  // Regex for replacing addition symbol with a space
        let decode = function(str) {
            return decodeURIComponent(str.replace(decodeRE, ' '))
        }
        let params = {}, e
        while (e = re.exec(pairs)) {
            let k = decode(e[1]), v = decode(e[2])
            if (k.substring(k.length - 2) === '[]') {
                if (includeArray) {
                    k = k.substring(0, k.length - 2)
                }
                (params[k] || (params[k] = [])).push(v)
            } else params[k] = v
        }
        return params
    }

    Ecommerce.removeWishlistItem = function() {
        $(document).on('click', '.remove-wishlist-item', function(event) {
            event.preventDefault()
            const _self = $(this)
            $.ajax({
                url: _self.data('url'),
                method: 'POST',
                data: {
                    _method: 'DELETE',
                },
                beforeSend: () => {
                    Loading.show()
                },
                success: (res) => {
                    if (res.error) {
                        showError(res.message)
                    } else {
                        showSuccess(res.message)
                        if (res.data.count === 0) {
                            $('.sb-btn-wishlist').load(window.siteUrl + ' .sb-btn-wishlist > *', function() {
                            })
                            $('.wishlist-page-content').load(window.siteConfig.wishlistUrl + ' .wishlist-page-content > *', function() {
                            })
                        } else {
                            $('.sb-top-bar-frame').find('.sb-wishlist-number').text(res.data.count)
                        }
                    }
                },
                error: (res) => {
                    handleError(res)
                },
                complete: () => {
                    Loading.hide()
                },
            })
        })
    }
})(jQuery)

Ecommerce.init()
