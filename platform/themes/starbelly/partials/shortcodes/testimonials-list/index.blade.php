<section class="sb-reviews sb-p-90-90">
    <div class="sb-bg-2">
        <div></div>
    </div>
    <div class="container">
        <div class="sb-masonry-grid">
            <div class="sb-grid-sizer"></div>
            @foreach($testimonials as $testimonial)
                <div class="sb-grid-item sb-item-50">
                    <div class="sb-review-card sb-mb-60">
                        <div class="sb-review-header sb-mb-15">
                            <h4 class="sb-mb-10">{!! BaseHelper::clean($testimonial->company) !!}</h4>
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
                            <h4>{!! BaseHelper::clean($testimonial->name) !!}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div>
            {{ $testimonials->links(Theme::getThemeNamespace('partials.pagination')) }}
        </div>
    </div>
</section>
