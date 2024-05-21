<section class="sb-p-0-30">
    <div class="container">
        <div class="row">
            @foreach(range(1, 6) as $i)
                @if(($title = $shortcode->{'title_' . $i}) && ($description = $shortcode->{'description_' . $i}))
                    <div class="col-lg-4">
                        <div class="sb-features-item sb-mb-60">
                            <div class="sb-number">{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</div>
                            <div class="sb-feature-text">
                                <h3 class="sb-mb-15">{!! BaseHelper::clean($title) !!}</h3>
                                <p class="sb-text">{!! BaseHelper::clean($description) !!}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
