<ul>
    <li><a href="{{ route('dashboard') }}"><i class="fas fa-home mr10 align-text-top"></i>Dashboard</a></li>

    @php
        $menu = config('menulinks.sections', []);
        $perms = auth()->user()->mergedPermissions();
        $hasProfile =
            isset($perms['users']) &&
            (in_array('*', (array) $perms['users']) || in_array('profile', (array) $perms['users']));
    @endphp

    @foreach ($menu as $section => $items)
        @php
            $visibleItems = [];
            foreach ($items as $it) {
                $m = $it['module'];
                if (isset($perms[$m]) && (in_array('*', (array) $perms[$m]) || in_array('index', (array) $perms[$m]))) {
                    $visibleItems[] = $it;
                }
            }
        @endphp

        @if (count($visibleItems))
            <p class="fz15 fw400 ff-heading pl30 mt30">{{ $section }}</p>
            @foreach ($visibleItems as $item)
                <li><a href="{{ route($item['route']) }}"><i
                            class="{{ $item['icon'] }} mr10 align-text-top"></i>{{ $item['label'] }}</a></li>
            @endforeach
        @endif
    @endforeach

    <p class="fz15 fw400 ff-heading pl30 mt30">Account</p>

    @if ($hasProfile)
        <li><a href="{{ route('users.profile') }}"><i class="fas fa-user-circle mr10 align-text-top"></i>My Profile</a>
        </li>
    @endif
    <li>
        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}" style="display: none;" id="logout-form">
            @csrf
        </form>

        <a href="javascript:void(0);" class="fw-bold" onclick="document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr5 align-text-top"></i>
            {{ __('Log Out') }}
        </a>
    </li>
</ul>
