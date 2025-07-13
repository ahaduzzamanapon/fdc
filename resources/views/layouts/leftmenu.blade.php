



@if (Auth::guard('producer')->check())
    <li class="nav-item">
        <a class="nav-link {!! Request::is('producer/dashboard') ? 'active' : '' !!}" aria-current="page" href="{{ route('producer.dashboard') }}">
            <i class="icon im im-icon-Home"></i>
            <span class="item-name">ড্যাশবোর্ড</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {!! Request::is('producer/booking') ? 'active' : '' !!}" aria-current="page" href="{{ route('producer.booking') }}">
            <i class="icon im im-icon-Home"></i>
            <span class="item-name">বুকিং</span>
        </a>
    </li>
@else

    {{-- Dashboard --}}
    <li class="nav-item">
        <a class="nav-link {!! Request::is('/') ? 'active' : '' !!}" aria-current="page" href="{{ url('/dashboard') }}">
            <i class="icon im im-icon-Home"></i>
            <span class="item-name">ড্যাশবোর্ড</span>
        </a>
    </li>
    @if (can('profile'))
    <li class="nav-item">
        <a class="nav-link {!! Request::is('profile') ? 'active' : '' !!}" aria-current="page" href="{{ url('/profile') }}">
            <i class="icon im im-icon-Home"></i>
            <span class="item-name">প্রোফাইল</span>
        </a>
    </li>
    @endif
    @if (can('producers_table'))
    <li class="nav-item">
        <a class="nav-link {!! Request::is('producers*') ? 'active' : '' !!}" aria-current="page" href="{{ route('producers.index') }}">
            <i class="icon im im-icon-Gear"></i>
            <span class="item-name">প্রযোজক</span>
        </a>
    </li>
    @endif
    {{-- Users Management --}}
    @if (can('hr'))
        <li class="nav-item">
            <a class="nav-link {!! Request::is('leaves*') ? 'active' : '' !!}" data-bs-toggle="collapse" href="#hr" role="button"
                aria-expanded="false" aria-controls="hr">
                <i class="icon im im-icon-Gear"></i>
                <span class="item-name">এইচ আর</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('leaves*')  ? 'show' : '' !!}" id="hr" data-bs-parent="#sidebar-menu">
                @if (can('leaves'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('leaves*') ? 'active' : '' !!}" href="{{ route('leaves.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> ছু </i>
                            <span class="item-name">ছুটি</span>
                        </a>
                    </li>
                @endif
                @if (can('leave_apply_list'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('leave-apply-list') ? 'active' : '' !!}" href="{{ route('leaves.apply.leave.list') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> ছু আ তা</i>
                            <span class="item-name">ছুটি আবেদন তালিকা</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    {{-- ব্যবহারকারী ব্যবস্থাপনা --}}
    @if (can('user_management'))
        <li class="nav-item">
            <a class="nav-link {!! Request::is('users*') || Request::is('roleAndPermissions*') ? 'active' : '' !!}" data-bs-toggle="collapse" href="#users_menu" role="button"
                aria-expanded="false" aria-controls="users_menu">
                <i class="icon im im-icon-User"></i>
                <span class="item-name">ব্যবহারকারী ব্যবস্থাপনা</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('users*') || Request::is('roleAndPermissions*') ? 'show' : '' !!}" id="users_menu" data-bs-parent="#sidebar-menu">
                @if (can('user'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('users*') ? 'active' : '' !!}" href="{{ route('users.index') }}">
                            <i class="icon im im-icon-User"></i>
                            <i class="sidenav-mini-icon"> ব্য</i>
                            <span class="item-name">ব্যবহারকারী</span>
                        </a>
                    </li>
                @endif
                @if (can('roll_and_permission'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('roleAndPermissions*') ? 'active' : '' !!}" href="{{ route('roleAndPermissions.index') }}">
                            <i class="icon im im-icon-Security-Settings"></i>
                            <i class="sidenav-mini-icon"> রো </i>
                            <span class="item-name">রোল ব্যবস্থাপনা</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    {{-- ইনভেন্টরি --}}
    @if (can('inventory'))
        <li class="nav-item">
            <a class="nav-link {!! (Request::is('inventory*') ? 'active' : '') !!}" data-bs-toggle="collapse"  href="#inventory_menu" role="button" aria-expanded="false" aria-controls="inventory_menu">
                <i class="icon im im-icon-Gear"></i>
                <span class="item-name">ইনভেন্টরি</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('inventory*') ? 'show' : '' !!}" id="inventory_menu" data-bs-parent="#sidebar-menu">
                @if (can('items'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('items*') ? 'active' : '' !!}" href="{{ route('items.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> আই </i>
                            <span class="item-name">আইটেম তালিকা</span>
                        </a>
                    </li>
                @endif
                @if (can('item_categories'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('itemCategories*') ? 'active' : '' !!}" href="{{ route('itemCategories.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> ক </i>
                            <span class="item-name">ক্যাটাগরি</span>
                        </a>
                    </li>
                @endif
                @if (can('item_units'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('itemUnits*') ? 'active' : '' !!}" href="{{ route('itemUnits.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> উ </i>
                            <span class="item-name">ইউনিট</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    {{-- সেটিংস --}}
    @if (can('settings'))
        <li class="nav-item">
            <a class="nav-link
            {!! (Request::is('siteSettings*') ||
            Request::is('districts*') ||
            Request::is('departments*')||
            Request::is('designations*')
            ? 'active' : '') !!}" data-bs-toggle="collapse" href="#settings_menu" role="button"
                aria-expanded="false" aria-controls="settings_menu">
                <i class="icon im im-icon-Gear"></i>
                <span class="item-name">সেটিংস</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('siteSettings*') ||
            Request::is('designations*') ||
            Request::is('districts*')||
            Request::is('departments*')
                ? 'show'
                : '' !!}" id="settings_menu" data-bs-parent="#sidebar-menu">
                @if (can('site_settings'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('siteSettings*') ? 'active' : '' !!}" href="{{ route('siteSettings.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> সি </i>
                            <span class="item-name">সাইট সেটিংস</span>
                        </a>
                    </li>
                @endif

                @if (can('designations'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('designations*') ? 'active' : '' !!}" href="{{ route('designations.index') }}">
                            <i class="icon im im-icon-Teacher"></i>
                            <i class="sidenav-mini-icon"> ডি </i>
                            <span class="item-name">পদবী</span>
                        </a>
                    </li>
                @endif
                @if (can('designations'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('departments*') ? 'active' : '' !!}" href="{{ route('departments.index') }}">
                            <i class="icon im im-icon-Teacher"></i>
                            <i class="sidenav-mini-icon"> ডি </i>
                            <span class="item-name">ডিপার্টমেন্ট</span>
                        </a>
                    </li>
                @endif
                @if (can('districts'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('districts*') ? 'active' : '' !!}" href="{{ route('districts.index') }}">
                            <i class="icon im im-icon-Structure"></i>
                            <i class="sidenav-mini-icon"> জে </i>
                            <span class="item-name">জেলা</span>
                        </a>
                    </li>
                @endif
                @if (can('upazilas'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('upazilas*') ? 'active' : '' !!}" href="{{ route('upazilas.index') }}">
                            <i class="icon im im-icon-Structure"></i>
                            <i class="sidenav-mini-icon"> উ </i>
                            <span class="item-name">উপজেলা</span>
                        </a>
                    </li>
                @endif
                @if (can('leave_type'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('leaveTypes*') ? 'active' : '' !!}" href="{{ route('leaveTypes.index') }}">
                            <i class="icon im im-icon-Structure"></i>
                            <i class="sidenav-mini-icon"> ল </i>
                            <span class="item-name">ছুটি প্রকার</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
@endif
