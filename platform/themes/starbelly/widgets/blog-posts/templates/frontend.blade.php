@if (is_plugin_active('blog'))
    @php
        Theme::asset()->usePath()->add('swiper-css', 'plugins/swiper.min.css');
        Theme::asset()->container('footer')->usePath()->add('swiper-js', 'plugins/swiper.min.js', ['jquery']);

        $limit = (int) Arr::get($config, 'limit');
        $posts = match (Arr::get($config, 'type')) {
            'recent' => get_recent_posts($limit),
            default => get_popular_posts($limit),
        };
    @endphp

    @switch($config['style'])
        @case('in-sidebar')
            <div>
                <div class="sb-ib-title-frame sb-mb-30">
                    <h4>{!! BaseHelper::clean(Arr::get($config, 'title')) !!}</h4><i class="fas fa-arrow-down"></i>
                </div>
                @foreach($posts as $post)
                    <a href="{{ $post->url }}" class="sb-blog-card sb-blog-card-sm sb-mb-30">
                        <div class="sb-cover-frame">
                            <img src="{{ RvMedia::getImageUrl($post->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $post->name }}">
                        </div>
                        <div class="sb-blog-card-descr">
                            <h5 class="sb-mb-5">{!! BaseHelper::clean($post->name) !!}</h5>
                            <p class="sb-text sb-text-sm">{!! BaseHelper::clean($post->description) !!}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @break
        @default
            <section class="sb-popular sb-p-60-30">
                <div class="sb-bg-3"></div>
                <div class="container">
                    <div class="sb-group-title sb-mb-30">
                        <div class="sb-left sb-mb-30">
                            <h2 class="sb-mb-30">{!! BaseHelper::clean(Arr::get($config, 'title')) !!}</h2>
                            <p class="sb-text">{!! BaseHelper::clean(Arr::get($config, 'description')) !!}</p>
                        </div>
                        <div class="sb-right sb-mb-30">
                            <div class="sb-slider-nav">
                                <div class="sb-prev-btn sb-blog-prev"><i class="fas fa-arrow-left"></i></div>
                                <div class="sb-next-btn sb-blog-next"><i class="fas fa-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-container sb-blog-slider-3i">
                        <div class="swiper-wrapper" style="height: auto;">
                            @foreach($posts as $post)
                                <div class="swiper-slide">
                                    <a href="{{ $post->url }}" class="sb-blog-card sb-mb-30">
                                        <div class="sb-cover-frame sb-mb-30">
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
                </div>
            </section>
    @endswitch
@endif
