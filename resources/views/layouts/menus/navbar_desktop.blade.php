<div class="dashboard_sidebar_list">
    <div class="sidebar_list_item">
        <a href="{{ route('dashboard') }}" class="items-center">
            <i class="fas fa-home mr15"></i>Dashboard</a>
    </div>

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
                <div class="sidebar_list_item">
                    <a href="{{ route($item['route']) }}" class="items-center">
                        <i class="{{ $item['icon'] }}"></i>{{ $item['label'] }}</a>
                </div>
            @endforeach
        @endif
    @endforeach

    <p class="fz15 fw400 ff-heading pl30 mt30">Account</p>

    @if ($hasProfile)
        <div class="sidebar_list_item">
            <a href="{{ route('users.profile') }}" class="items-center">
                <i class="fas fa-user-circle mr15"></i>My Profile</a>
        </div>
    @endif

    <div class="sidebar_list_item">
        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" class="items-center"
                onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt mr15"></i>Log Out</a>
        </form>
    </div>
</div>
