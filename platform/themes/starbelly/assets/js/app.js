import { showError, showSuccess, handleError } from './utils'

$(function() {

    'use strict'
    /***************************

     preloader

     ***************************/
    const Loading = $('#loading')

    $(document).ready(function() {
        $('.sb-loading').animate({
            opacity: 1,
        }, {
            duration: 500,
        })
        setTimeout(function() {
            $('.sb-preloader-number').each(function() {
                let $this = $(this),
                    countTo = $this.attr('data-count')
                $({
                    countNum: $this.text(),
                }).animate({
                    countNum: countTo,
                }, {
                    duration: 1000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.floor(this.countNum))
                    },
                })
            })
        }, 400)
    })
    /***************************

     faq

     ***************************/
    $('.sb-faq li .sb-question').on('click', function() {
        $(this).find('.sb-plus-minus-toggle').toggleClass('sb-collapsed')
        $(this).parent().toggleClass('sb-active')
    })
    /***************************

     isotope

     ***************************/
    $('.sb-filter a').on('click', function() {
        $('.sb-filter .sb-active').removeClass('sb-active')
        $(this).addClass('sb-active')

        let selector = $(this).data('filter')
        if ($('.sb-masonry-grid').length) {
            $('.sb-masonry-grid').isotope({
                filter: selector,
            })
        }
        return false
    })
    $(document).ready(function() {
        if ($('.sb-masonry-grid').length) {
            $('.sb-masonry-grid').isotope({
                itemSelector: '.sb-grid-item',
                percentPosition: true,
                masonry: {
                    columnWidth: '.sb-grid-sizer',
                },
            })
        }
    })
    if ($('.sb-tabs').length) {
        $('.sb-tabs').isotope({
            filter: '.sb-details-tab',
        })
    }
    /***************************

     fancybox

     ***************************/
    if ($('[data-fancybox="menu"]').length) {
        $('[data-fancybox="menu"]').fancybox({
            animationEffect: 'zoom-in-out',
            animationDuration: 600,
            transitionDuration: 1200,
        })
    }

    if ($('[data-fancybox="gallery"]').length) {
        $('[data-fancybox="gallery"]').fancybox({
            animationEffect: 'zoom-in-out',
            animationDuration: 600,
            transitionDuration: 1200,
        })
    }

    // $.fancybox.defaults.hash = false;
    /***************************

     discount popup

     ***************************/
    function showPopup() {
        $('.sb-popup-frame').addClass('sb-active')
    }

    if ($('.timeout-popup').length) {
        setTimeout(showPopup, $('.timeout-popup').val())
        $('.sb-close-popup , .sb-ppc').on('click', function() {
            $('.sb-popup-frame').removeClass('sb-active')
        })
    }
    /***************************

     click effect

     ***************************/
    const cursor = document.querySelector('.sb-click-effect')
    if (cursor) {
        document.addEventListener('mousemove', (e) => {
            cursor.setAttribute('style', 'top:' + (e.pageY - 15) + 'px; left:' + (e.pageX - 15) + 'px;')
        })

        document.addEventListener('click', () => {
            cursor.classList.add('sb-click')
            setTimeout(() => {
                cursor.classList.remove('sb-click')
            }, 600)
        })
    }

    $('.sb-menu-btn').on('click', function() {
        $('.sb-menu-btn , .sb-navigation').toggleClass('sb-active')
        $('.sb-info-btn , .sb-info-bar , .sb-minicart').removeClass('sb-active')
    })
    $('.sb-info-btn').on('click', function() {
        $('.sb-info-btn , .sb-info-bar').toggleClass('sb-active')
        $('.sb-menu-btn , .sb-navigation , .sb-minicart').removeClass('sb-active')
    })
    $('.sb-btn-cart').on('click', function() {
        $('.sb-minicart').toggleClass('sb-active')
        $('.sb-info-btn , .sb-info-bar , .sb-navigation , .sb-menu-btn , .sb-info-btn').removeClass('sb-active')
    })
    $(window).on('scroll', function() {
        let scroll = $(window).scrollTop()
        if (scroll >= 10) {
            $('.sb-top-bar-frame').addClass('sb-scroll')
        } else {
            $('.sb-top-bar-frame').removeClass('sb-scroll')
        }
        if (scroll >= 10) {
            $('.sb-info-bar , .sb-minicart').addClass('sb-scroll')
        } else {
            $('.sb-info-bar , .sb-minicart').removeClass('sb-scroll')
        }
    })
    $(document).on('click', function(e) {
        let el = '.sb-minicart , .sb-btn-cart , .sb-menu-btn , .sb-navigation , .sb-info-btn , .sb-info-bar'
        if (jQuery(e.target).closest(el).length) return
        $('.sb-minicart , .sb-btn-cart , .sb-menu-btn , .sb-navigation , .sb-info-btn , .sb-info-bar').removeClass('sb-active')
    })

    if ($(window).width() < 992) {
        $('.sb-has-children > a').attr('href', '#.')
    }
    $(window).resize(function() {
        if ($(window).width() < 992) {
            $('.sb-has-children > a').attr('href', '#.')
        }
    })
    /***************************

     quantity

     ***************************/
    $('.sb-add').on('click', function() {
        if ($(this).prev().val() < 10) {
            $(this).prev().val(+$(this).prev().val() + 1)
        }
    })
    $('.sb-sub').on('click', function() {
        if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1)
        }
    })
    /***************************

     sticky

     ***************************/
    let sticky = new Sticky('.sb-sticky')
    if ($(window).width() < 992) {
        sticky.destroy()
    }
    /***************************

     sliders

     ***************************/
    if (typeof Swiper !== 'undefined') {
        new Swiper('.sb-short-menu-slider-3i', {
            slidesPerView: 3,
            spaceBetween: 30,
            parallax: true,
            speed: 1000,
            navigation: {
                prevEl: '.sb-short-menu-prev',
                nextEl: '.sb-short-menu-next',
            },
            breakpoints: {
                992: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 1,
                },
            },
        })
        new Swiper('.sb-short-menu-slider-2-3i', {
            slidesPerView: 3,
            spaceBetween: 30,
            parallax: true,
            speed: 1000,
            navigation: {
                prevEl: '.sb-short-menu-prev-2',
                nextEl: '.sb-short-menu-next-2',
            },
            breakpoints: {
                992: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 1,
                },
            },
        })
        new Swiper('.sb-short-menu-slider-4i', {
            slidesPerView: 4,
            spaceBetween: 30,
            parallax: true,
            speed: 1000,
            navigation: {
                prevEl: '.sb-short-menu-prev',
                nextEl: '.sb-short-menu-next',
            },
            breakpoints: {
                992: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 1,
                },
            },
        })
        new Swiper('.sb-short-menu-slider-2-4i', {
            slidesPerView: 4,
            spaceBetween: 30,
            parallax: true,
            speed: 1000,
            navigation: {
                prevEl: '.sb-short-menu-prev-2',
                nextEl: '.sb-short-menu-next-2',
            },
            breakpoints: {
                992: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 1,
                },
            },
        })
        new Swiper('.sb-reviews-slider', {
            slidesPerView: 2,
            spaceBetween: 30,
            parallax: true,
            speed: 1000,
            navigation: {
                prevEl: '.sb-reviews-prev',
                nextEl: '.sb-reviews-next',
            },
            breakpoints: {
                992: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 1,
                },
            },
        })
        new Swiper('.sb-blog-slider-2i', {
            slidesPerView: 2,
            spaceBetween: 30,
            parallax: true,
            speed: 1000,
            navigation: {
                prevEl: '.sb-blog-prev',
                nextEl: '.sb-blog-next',
            },
            breakpoints: {
                992: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 1,
                },
            },
        })
        new Swiper('.sb-blog-slider-3i', {
            slidesPerView: 3,
            spaceBetween: 30,
            parallax: true,
            speed: 1000,
            navigation: {
                prevEl: '.sb-blog-prev',
                nextEl: '.sb-blog-next',
            },
            breakpoints: {
                992: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 1,
                },
            },
        })
    }
    /***************************

     map

     ***************************/
    if ($('div').is('#map')) {
        mapboxgl.accessToken = 'pk.eyJ1Ijoic3Rvc2NhciIsImEiOiJja2VpbDE4b2UwbDg3MnNwY2d3YzlvcDV5In0.e26tLedpKwxrkOmPkWhQlg'
        let map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/stoscar/ckk6qpt2h0yi517o77x3tw34f',
            center: [-79.394900, 43.643102],
            zoom: 15,
        })
        let marker = new mapboxgl.Marker()
            .setLngLat([-79.394900, 43.643102])
            .addTo(map)
    }
    $('.sb-lock').on('click', function() {
        $('.sb-map').toggleClass('sb-active')
        $('.sb-lock').toggleClass('sb-active')
        $('.sb-lock .fas').toggleClass('fa-unlock')
    })

    /***************************

     datepicker

     ***************************/
    if ($('.sb-datepicker').length) {
        $('.sb-datepicker').datepicker({
            minDate: new Date(),
        })
    }

    $('.newsletter-form button[type=submit]').on('click', function(event) {
        event.preventDefault()
        event.stopPropagation()

        let _self = $(this)
        $.ajax({
            type: 'POST',
            cache: false,
            url: _self.closest('form').prop('action'),
            data: new FormData(_self.closest('form')[0]),
            contentType: false,
            processData: false,
            beforeSend: () => {
                Loading.show()
            },
            success: res => {
                if (!res.error) {
                    _self.closest('form').find('input[type=email]').val('')
                    showSuccess(res.message)
                } else {
                    showError(res.message)
                }
            },
            error: res => {
                handleError(res)
            },
            complete: () => {
                if (typeof refreshRecaptcha !== 'undefined') {
                    refreshRecaptcha()
                }
                Loading.hide()
            },
        })
    })
})
