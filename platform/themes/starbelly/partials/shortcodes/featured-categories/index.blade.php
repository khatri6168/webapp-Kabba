<section class="sb-p-0-60">
    <div class="container">
        @switch($shortcode->style)
            @case(2)
                @if($categories->count())
                    <div class="row">
                        @if ($title = $shortcode->title)
                            <h2 class="sb-mb-30" align="center">{!! BaseHelper::clean($title) !!}</h2>
                        @endif
                        @foreach($categories as $category)
                            <div class="col-lg-4">
                                <a href="{{ $category->url }}">
                                    <div class="sb-categorie-card sb-mb-30" style="border: 1px solid #cccccc; border-radius: 15px;">
                                        <div class="sb-card-body">
                                            <div {{-- class="sb-category-icon" --}}>
                                                <img src="{{ RvMedia::getImageUrl($category->image) }}" alt="{{ $category->name }}" width="250">
                                            </div>
                                            <div class="sb-card-descr">
                                                <h3 class="sb-mb-10">{!! BaseHelper::clean($category->name) !!}</h3>
                                                
                                                <span href="{{ $category->url }}" class="sb-btn sb-btn-2 sb-btn-icon sb-m-0">
                                                    <span class="sb-icon">
                                                        <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="{{ $category->name }}">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            @break
            @default
                <div class="sb-group-title sb-mb-30">
                    <div class="sb-left sb-mb-30">
                        @if ($title = $shortcode->title)
                            <h2 class="sb-mb-30">{!! BaseHelper::clean($title) !!}</h2>
                        @endif

                        @if($subtitle = $shortcode->subtitle)
                            <p class="sb-text">{!! BaseHelper::clean($subtitle) !!}</p>
                        @endif
                    </div>

                    @if ($shortcode->button_label || $shortcode->button_url)
                        <div class="sb-right sb-mb-30">
                            <a href="{{ $shortcode->button_url ?? '#' }}" class="sb-btn sb-m-0">
                                <span class="sb-icon">
                                  <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="{{ __('icon') }}">
                                </span>
                                <span>{!! BaseHelper::clean($shortcode->button_label ?? __('Go shipping now')) !!}</span>
                            </a>
                        </div>
                    @endif
                </div>
                @if ($categories->count())
                    <div class="row">
                        @foreach ($categories as $category)
                            <div class="col-lg-6">
                                <a href="{{ $category->url }}" class="sb-categorie-card sb-categorie-card-2 sb-mb-30">
                                    <div class="sb-card-body">
                                        <div class="sb-category-icon">
                                            <img src="{{ RvMedia::getImageUrl($category->image) }}" alt="icon">
                                        </div>
                                        <div class="sb-card-descr">
                                            <h3 class="sb-mb-10">{!! BaseHelper::clean($category->name) !!}</h3>
                                            <p class="sb-text">{!! BaseHelper::clean($category->description) !!}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
        @endswitch
    </div>
</section>
