@foreach($attributeSets as $attributeSet)
    @if(view()->exists($view = Theme::getThemeNamespace('views.ecommerce.attributes._layouts-filter.' . $attributeSet->display_layout)))
        @include($view, [
            'set'  => $attributeSet,
            'attributes' => $attributeSet->attributes,
            'selected' => (array)request()->query('attributes', []),
        ])
    @else
        @include(Theme::getThemeNamespace('views.ecommerce.attributes._layouts.dropdown'), [
            'set' => $attributeSet,
            'attributes' => $attributeSet->attributes,
            'selected' => (array)request()->query('attributes', []),
        ])
    @endif
@endforeach
