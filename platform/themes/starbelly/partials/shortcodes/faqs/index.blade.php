<section class="sb-p-90-0">
    <div class="container">
        @foreach($categories as $category)
            <div class="row sb-mb-60">
                <div class="col-lg-12">
                    <div class="sb-mb-30">
                        <h2 class="sb-cate-title">{!! BaseHelper::clean($category->name) !!}</h2>
                    </div>
                </div>
                @foreach($category->faqs->split(2) as $faqs)
                    <div class="col-lg-6">
                        <ul class="sb-faq">
                           @foreach($faqs as $faq)
                                <li>
                                    <div class="sb-question">
                                        <h4>{!! BaseHelper::clean($faq->question) !!}</h4>
                                        <span class="sb-plus-minus-toggle sb-collapsed"></span>
                                    </div>
                                    <div class="sb-answer sb-text">{!! BaseHelper::clean($faq->answer) !!}</div>
                                </li>
                           @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
