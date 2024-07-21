<!-- Start sidebar menu -->
@if(!empty($me->sidebar_menu))
    @dump(['sidebar_menu'=>$me->sidebar_menu])
    <div class="sidebar">
        @foreach ($me->sidebar_menu as $key => $subMenu)
            <h6 class="px-3 mt-3">{{ ucfirst($key) }}</h6>
            @foreach ($subMenu as $subKey => $subSubMenu)
                @if (is_array($subSubMenu))
                    <div class="px-3">
                        <h6>{{ ucfirst($subKey) }}</h6>
                        @foreach ($subSubMenu as $menuKey => $url)
                            <a href="{{ $url }}">{{ ucfirst(last(explode('|', $menuKey))) }}</a>
                        @endforeach
                    </div>
                @else
                    <a href="{{ $subSubMenu }}">{{ ucfirst($subKey) }}</a>
                @endif
            @endforeach
        @endforeach
    </div>
@endif