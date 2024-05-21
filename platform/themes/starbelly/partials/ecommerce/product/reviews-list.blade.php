<div class="d-flex align-items-center justify-content-end mb-4 gap-3">
    <div class="rating-star mb-1">
        <span class="rating-star-item" style="width: {{ $product->reviews_avg * 20 }}%"></span>
    </div>
    <h6 class="ml-3">{{ __(':avg out of :total', ['avg' => number_format($product->reviews_avg, 2), 'total' => 5]) }}</h6>
</div>

@foreach($product->reviews as $review)
    <div class="sb-review-card sb-mb-30">
        <div class="d-flex justify-content-between sb-review-header sb-mb-15">
            <span class="sb-text sb-text-sm">{{ $review->created_at->diffForHumans() }}</span>
            <ul class="sb-stars">
                @foreach(range(1, 5) as $i)
                    @if($i <= $review->star)
                        <li><i class="fas fa-star"></i></li>
                    @else
                        <li style="color: #d9d9d9"><i class="fas fa-star"></i></li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="sb-mb-15">
            <p class="sb-text">{!! BaseHelper::clean($review->comment) !!}</p>
            @if($review->images)
                <div class="review-images mt-2">
                    @foreach($review->images as $image)
                        @php($url = RvMedia::getImageUrl($image))
                        <a href="{{ $url }}">
                            <img src="{{ $url }}" data-fancybox="review-{{ $review->id }}" alt="{{ $url }}" class="img-fluid rounded h-100">
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="sb-author-frame">
            <div class="sb-avatar-frame">
                <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}">
            </div>
            <h4>{{ $review->user->name }}</h4>
        </div>
    </div>
@endforeach
