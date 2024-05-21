<section class="sb-reviews sb-p-0-90">
    <div class="container">
        <div class="sb-group-title sb-mb-30">
            <div class="sb-left sb-mb-30">
                <h2 class="sb-mb-30">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                <p class="sb-text">{!! BaseHelper::clean($shortcode->description) !!}</p>
            </div>
            <div class="sb-right sb-mb-30">
                <div class="sb-slider-nav">
                    <div class="sb-prev-btn sb-reviews-prev"><i class="fas fa-arrow-left"></i></div>
                    <div class="sb-next-btn sb-reviews-next"><i class="fas fa-arrow-right"></i></div>
                </div>
                @if($shortcode->button_label || $shortcode->button_icon)
                    <a href="{{ $shortcode->button_url }}" class="sb-btn">
                        <span class="sb-icon">
                            <img src="{{ RvMedia::getImageUrl($shortcode->button_icon) }}" alt="{{ $shortcode->button_label }}">
                        </span>
                        <span>{!! BaseHelper::clean($shortcode->button_label) !!}</span>
                    </a>
                @endif
            </div>
        </div>
        <div class="swiper-container sb-reviews-slider">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="sb-review-card">
                            <div class="sb-review-header sb-mb-15">
                                <h4 class="sb-mb-15">{{ $testimonial->company }}</h4>
                                <ul class="sb-stars">
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                </ul>
                            </div>
                            <p class="sb-text sb-mb-15">{!! BaseHelper::clean($testimonial->content) !!}</p>
                            <div class="sb-author-frame">
                                <div class="sb-avatar-frame">
                                    <img src="{{ RvMedia::getImageUrl($testimonial->image) }}" alt="{{ $testimonial->name }}">
                                </div>
                                <h4>{{ $testimonial->name }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
