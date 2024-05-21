<ul {!! $options !!}>
    @foreach($menu_nodes->loadMissing('metadata') as $key => $row)
        <li @class(['sb-has-children' => $row->has_child, 'sb-active' => $row->active])>
            <a href="{{ url($row->url) }}" target="{{ $row->target }}">
                @if ($iconImage = $row->getMetadata('icon_image', true))
                    <img src="{{ RvMedia::getImageUrl($iconImage) }}" class="w-3 h-3 inline-block align-top mt-[5px]" />
                @elseif ($row->icon_font)
                    <i class="{{ trim($row->icon_font) }}"></i>
                @endif
                {{ $row->title }}
            </a>
            @if ($row->has_child)
                {!!
                    Menu::generateMenu([
                        'menu' => $menu,
                        'view'  => 'main-menu',
                        'options' => ['class' => 'submenu'],
                        'menu_nodes' => $row->child,
                    ])
                !!}
            @endif
        </li>
    @endforeach
</ul>
