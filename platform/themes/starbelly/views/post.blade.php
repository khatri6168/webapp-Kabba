@php($withSidebar = (theme_option('blog_post_detail_style') === 'with-sidebar'))

<section class="sb-publication sb-p-90-90">
    <div class="container" @if($withSidebar) data-sticky-container @endif>
        <div @class(['row', 'justify-content-center' => ! $withSidebar])>
            <div class="col-lg-8">
                <div class="sb-author-panel">
                    <div class="sb-author-frame">
                        <div class="sb-avatar-frame">
                            <img src="{{ $post->author->avatar_url }}" alt="{{ $post->author->name }}">
                        </div>
                        <h4>{{ $post->author->name }}</h4>
                    </div>
                    <div>
                        <div class="sb-subtitle">
                            <span>{{ $post->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                        <div class="sb-subtitle">
                            <i class="fas fa-eye"></i>
                            <span>{{ number_format($post->views) }}</span>
                        </div>
                    </div>
                </div>
                <div class="sb-post-cover sb-mb-30">
                    <img src="{{ RvMedia::getImageUrl($post->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $post->title }}">
                </div>
                <div>
                    <div class="ck-content">{!! BaseHelper::clean($post->content) !!}</div>
                </div>
            </div>
            @if($withSidebar)
                <div class="col-lg-4">
                    <div class="sb-sidebar-frame sb-pad-type-2 sb-sticky" data-margin-top="120">
                        <div class="sb-sidebar">
                            {!! dynamic_sidebar('blog-sidebar') !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

{!! dynamic_sidebar('blog-footer') !!}
