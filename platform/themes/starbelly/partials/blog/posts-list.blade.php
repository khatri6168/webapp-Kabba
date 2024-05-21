@foreach($posts as $post)
    <div @class(['sb-grid-item', 'sb-item-33' => $style === 1, 'sb-item-50' => $style === 2 || $style === 3])>
        <a href="{{ $post->url }}" class="sb-blog-card sb-mb-30">
            <div @class(['sb-cover-frame sb-mb-30', 'sb-cover-vert' => $loop->even])>
                <img src="{{ RvMedia::getImageUrl($post->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $post->name }}">
                @if($post->is_featured)
                    <div class="sb-badge">{{ __('Featured') }}</div>
                @endif
            </div>
            <div class="sb-blog-card-descr">
                <h3 class="sb-mb-10">{!! BaseHelper::clean($post->name) !!}</h3>
                <div class="sb-subtitle sb-mb-15">
                    <span>{{ $post->created_at->translatedFormat('d M Y') }}</span>
                </div>
                <div class="sb-subtitle sb-mb-15 ms-2">
                    <span>{{ $post->author->name }}</span>
                </div>
                <p class="sb-text">{!! BaseHelper::clean($post->description) !!}</p>
            </div>
        </a>
    </div>
@endforeach
