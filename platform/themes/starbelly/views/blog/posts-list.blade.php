<section class="sb-blog-list sb-p-90-90">
    <div class="sb-bg-1">
        <div></div>
    </div>
    <div class="container" data-sticky-container>
        <div class="row">
            <div class="col-lg-8">
                <div class="sb-masonry-grid">
                    <div class="sb-grid-sizer"></div>
                    @foreach($posts as $post)
                        <div class="sb-grid-item sb-item-50">
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
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sb-sidebar-frame sb-pad-type-1 sb-sticky" data-margin-top="120">
                    <div class="sb-sidebar">
                        {!! dynamic_sidebar('blog-sidebar') !!}
                    </div>
                </div>
            </div>
        </div>
        <div>
            {{ $posts->links(Theme::getThemeNamespace('partials.pagination')) }}
        </div>
    </div>
</section>
