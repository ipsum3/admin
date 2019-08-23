<nav class="menu" id="menu">

    @foreach(config('ipsum.menu') as $group_key => $group)
        @if (!empty($group['title']))
            <div class="menu-title">{{ $group['title'] }}</div>
        @endif
        @foreach($group['sections'] as $section_key => $section)
            <ul class="menu-section">
                <li>
                    @if (!isset($section['submenus']))
                        <a class="menu-link {{ request()->is(config('ipsum.admin.route_prefix').$section['url_prefix']) ? 'active' : '' }}" href="{{ !empty($section['route']) ? route($section['route'][0], (isset($section['route'][1]) ? $section['route'][1] : null)) : url($section['url']) }}">
                            <i class="menu-link-icon {{ $section['icon'] }}"></i>
                            {{ $section['title'] }}
                        </a>
                    @else
                        @php
                        $urls_prefix = [];
                        foreach($section['submenus'] as $submenu_key => $submenu) {
                            if (!empty($submenu['url_prefix'])) {
                                $urls_prefix[] = config('ipsum.admin.route_prefix').$submenu['url_prefix'];
                            }
                            if ((!empty($submenu['gate']) and !Gate::allows($submenu['gate'])) or (!empty($submenu['can']) and !auth()->user()->can($submenu['can'][0], $submenu['can'][1]))) {
                                unset($section['submenus'][$submenu_key]);
                            }
                        }
                        if (!count($section['submenus'])) {
                            continue;
                        }
                        $open = request()->is($urls_prefix);
                        @endphp
                        <a class="menu-link" data-toggle="collapse" href="#menu-{{ $group_key }}-{{ $section_key }}" role="button" aria-expanded="{{ $open ? 'true' : 'false' }}" aria-controls="collapseOne">
                            <i class="menu-link-icon {{ $section['icon'] }}"></i>
                            <span class="menu-link-text">{{ $section['title'] }}</span>
                            <i class="menu-link-right fas fa-angle-down"></i>
                        </a>
                        <ul class="menu-submenu collapse {{ $open ? 'show' : '' }}" id="menu-{{ $group_key }}-{{ $section_key }}" data-parent="#menu">
                            @foreach($section['submenus'] as $submenu)
                                <li>
                                    <a class="menu-link {{ (!empty($submenu['url_prefix']) and request()->is(config('ipsum.admin.route_prefix').$submenu['url_prefix'])) ? 'active' : '' }}" href="{{ !empty($submenu['route']) ? route($submenu['route'][0], (isset($submenu['route'][1]) ? $submenu['route'][1] : null)) : url($submenu['url']) }}">
                                        <i class="menu-link-icon fas fa-circle"></i>
                                        <span class="menu-link-text">{{ $submenu['text'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            </ul>
        @endforeach
    @endforeach

</nav>