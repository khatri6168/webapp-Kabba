<section class="sb-p-90-30">
    <div class="container">
        <div class="row">
            @for ($i = 1; $i <= 3; $i++)
                @if ($shortcode->{'title_' . $i} || $shortcode->{'description_' . $i})
                    <div class="col-lg-4">
                        <div class="sb-features-item sb-mb-60">
                            <div class="sb-number">0{{ $i }}</div>
                            <div class="sb-feature-text">
                                <h3 class="sb-mb-15">{!! BaseHelper::clean($shortcode->{'title_' . $i}) !!}</h3>
                                <p class="sb-text">{!! BaseHelper::clean($shortcode->{'description_' . $i}) !!}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
</section>
