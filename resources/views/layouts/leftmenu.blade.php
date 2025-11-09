{{-- Producer --}}
@if (Auth::guard('producer')->check())
    <li class="nav-item">
        <a class="nav-link {!! Request::is('producer/dashboard') ? 'active' : '' !!}" aria-current="page"
            href="{{ route('producer.dashboard') }}">
            <i class="icon im im-icon-Home"></i>
            <span class="item-name">{{ 'বুকিং ড্যাশবোর্ড' }}</span>
        </a>
    </li>
    {{-- Booking --}}
    <li class="nav-item">
        <a class="nav-link {!! Request::is('producer/booking') ? 'active' : '' !!}" aria-current="page"
            href="{{ route('producer.booking') }}">
            <i class="icon im im-icon-Home"></i>
            <span class="item-name">সেবা {{ __('messages.booking') }}</span>
        </a>
    </li>

    {{-- সেবা সমূহ --}}
    <li class="nav-item">
        <a class="nav-link {!! Request::is('filmApplications*') || Request::is('dramaApplications*') || Request::is('docufilmApplications*') || Request::is('realityApplications*') || Request::is('partyApplications*') ? 'active' : '' !!}" data-bs-toggle="collapse" href="#services" role="button" aria-expanded="false" aria-controls="hr">
            <i class="icon im im-icon-Gear"></i>
            <span class="item-name"> সেবা সমূহ </span>
            <i class="right-icon im im-icon-Arrow-Right"></i>
        </a>
        <ul class="sub-nav collapse {!! Request::is('filmApplications*') ? 'show' : '' !!}" id="services"
            data-bs-parent="#sidebar-menu">

            {{-- Film Application --}}
            <li class="nav-item">
                <a class="nav-link {!! Request::is('filmApplications*') ? 'active' : '' !!}" aria-current="page"
                    href="{{ route('filmApplications.index') }}">
                    <i class="icon im im-icon-Home"></i>
                    <span class="item-name">{{ __('messages.film_application') }}</span>
                </a>
            </li>

            {{-- নাটক অ্যাপ্লিকেশন --}}
            <li class="nav-item">
                <a class="nav-link {!! Request::is('dramaApplications*') ? 'active' : '' !!}"
                    href="{{ route('dramaApplications.index') }}">
                    <i class="icon im im-icon-Settings-Window"></i>
                    <i class="sidenav-mini-icon"> তা </i>
                    <span class="item-name">নাটক অ্যাপ্লিকেশন</span>
                </a>
            </li>

            {{-- প্রামান্যচিত্র অ্যাপ্লিকেশন --}}
            <li class="nav-item">
                <a class="nav-link {!! Request::is('docufilmApplications*') ? 'active' : '' !!}"
                    href="{{ route('docufilmApplications.index') }}">
                    <i class="icon im im-icon-Settings-Window"></i>
                    <i class="sidenav-mini-icon"> তা </i>
                    <span class="item-name">প্রামান্যচিত্র অ্যাপ্লিকেশন</span>
                </a>
            </li>

            {{-- রিয়েলিটি শো অ্যাপ্লিকেশন --}}
            <li class="nav-item">
                <a class="nav-link {!! Request::is('realityApplications*') ? 'active' : '' !!}"
                    href="{{ route('realityApplications.index') }}">
                    <i class="icon im im-icon-Settings-Window"></i>
                    <i class="sidenav-mini-icon"> তা </i>
                    <span class="item-name">রিয়েলিটি শো অ্যাপ্লিকেশন</span>
                </a>
            </li>

            {{-- পার্টি অ্যাপ্লিকেশন --}}
            @php
                $type = Auth::guard('producer')->user();
            @endphp
            @if ($type->desk_id == null && $type->status == 'Inactive')
                <li class="nav-item">
                    <a class="nav-link {!! Request::is('partyApplications*') ? 'active' : '' !!}"
                        href="{{ route('partyApplications.create') }}">
                        <i class="icon im im-icon-Settings-Window"></i>
                        <i class="sidenav-mini-icon"> পা </i>
                        <span class="item-name">পার্টি অ্যাপ্লিকেশন</span>
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link {!! Request::is('partyApplications*') ? 'active' : '' !!}"
                        href="{{ route('partyApplications.index') }}">
                        <i class="icon im im-icon-Settings-Window"></i>
                        <i class="sidenav-mini-icon"> পা </i>
                        <span class="item-name">পার্টি অ্যাপ্লিকেশন</span>
                    </a>
                </li>
            @endif

        </ul>
    </li>


    {{-- পেমেন্ট --}}
    <li class="nav-item">
        <a class="nav-link {!! Request::is('makePayments*') ? 'active' : '' !!}"
            href="{{ route('makePayments.index') }}">
            <i class="icon im im-icon-Settings-Window"></i>
            <i class="sidenav-mini-icon"> পা </i>
            <span class="item-name">পেমেন্ট তালিকা</span>
        </a>
    </li>
@else

    {{-- Dashboard --}}
    <li class="nav-item">
        <a class="nav-link {!! Request::is('/') ? 'active' : '' !!}" aria-current="page" href="{{ url('/dashboard') }}">
            <i class="icon im im-icon-Home"></i>
            <span class="item-name">{{ __('messages.dashboard') }}</span>
        </a>
    </li>

    {{-- @if (can('booking_table'))
    <li class="nav-item">
        <a class="nav-link {!! Request::is('producer/booking') ? 'active' : '' !!}" aria-current="page"
            href="{{ route('producer.booking') }}">
            <i class="icon im im-icon-Home"></i>
            <span class="item-name">{{ __('messages.booking') }}</span>
        </a>
    </li>
    @endif --}}

    {{-- বুকিং --}}
    @if (can('filmApplications_table'))   {{-- booking_table --}}
        <li class="nav-item">
            <a class="nav-link {!! Request::is('producer*') || Request::is('drama-application*') ? 'active' : '' !!}" data-bs-toggle="collapse"  href="#producerBooking" role="button" aria-expanded="false" aria-controls="hr"> <i class="icon im im-icon-Gear"></i> <span class="item-name"> বুকিং </span> <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('producer*') ? 'show' : '' !!}" id="producerBooking"
                data-bs-parent="#sidebar-menu">
                @if (can('film_applications_index_list'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('producer/booking') ? 'active' : '' !!}" aria-current="page" href="{{ route('producer.booking') }}"> <i class="icon im im-icon-Home"></i> <span class="item-name">{{ __('messages.booking') }}</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {!! Request::is('producer/booking_forward_table') ? 'active' : '' !!}"
                        href="{{ route('producerBooking.forward.table') }}">
                        <i class="icon im im-icon-Settings-Window"></i>
                        <i class="sidenav-mini-icon"> অ </i>
                        <span class="item-name">{{ __('messages.pending_list') }}</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    {{-- Film Application --}}
    @if (can('filmApplications_table'))
        <li class="nav-item">
            <a class="nav-link {!! Request::is('filmApplications*') || Request::is('film-application*') ? 'active' : '' !!}" data-bs-toggle="collapse"
                href="#filmApplications" role="button" aria-expanded="false" aria-controls="hr">
                <i class="icon im im-icon-Gear"></i>
                <span class="item-name">{{ __('messages.film_application') }}</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('filmApplications*') ? 'show' : '' !!}" id="filmApplications"
                data-bs-parent="#sidebar-menu">
                @if (can('film_applications_index_list'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('filmApplications') ? 'active' : '' !!}"
                            href="{{ route('filmApplications.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> তা </i>
                            <span class="item-name">{{ __('messages.list') }}</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {!! Request::is('filmApplications_forward_table*') ? 'active' : '' !!}"
                        href="{{ route('filmApplications.forward.table') }}">
                        <i class="icon im im-icon-Settings-Window"></i>
                        <i class="sidenav-mini-icon"> অ </i>
                        <span class="item-name">{{ __('messages.pending_list') }}</span>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {!! Request::is('filmApplications_backward_table*') ? 'active' : '' !!}"
                        href="{{ route('filmApplications.backward.table') }}">
                        <i class="icon im im-icon-Settings-Window"></i>
                        <i class="sidenav-mini-icon"> রি </i>
                        <span class="item-name">{{ __('messages.review_list') }}</span>
                    </a>
                </li> --}}

            </ul>
        </li>
    @endif

    {{-- Drama Application --}}
    @if (can('filmApplications_table'))
        <li class="nav-item">
            <a class="nav-link {!! Request::is('dramaApplications*') || Request::is('drama-application*') ? 'active' : '' !!}" data-bs-toggle="collapse"
                href="#dramaApplications" role="button" aria-expanded="false" aria-controls="hr">
                <i class="icon im im-icon-Gear"></i>
                <span class="item-name">নাটক অ্যাপ্লিকেশন</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('dramaApplications*') ? 'show' : '' !!}" id="dramaApplications"
                data-bs-parent="#sidebar-menu">
                @if (can('film_applications_index_list'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('dramaApplications') ? 'active' : '' !!}"
                            href="{{ route('dramaApplications.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> তা </i>
                            <span class="item-name">{{ __('messages.list') }}</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {!! Request::is('dramaApplications_forward_table*') ? 'active' : '' !!}"
                        href="{{ route('dramaApplications.forward.table') }}">
                        <i class="icon im im-icon-Settings-Window"></i>
                        <i class="sidenav-mini-icon"> অ </i>
                        <span class="item-name">{{ __('messages.pending_list') }}</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    {{-- প্রামান্যচিত্র অ্যাপ্লিকেশন --}}
    @if (can('filmApplications_table'))
        <li class="nav-item">
            <a class="nav-link {!! Request::is('docufilmApplications*') || Request::is('docufilm-application*') ? 'active' : '' !!}" data-bs-toggle="collapse"
                href="#docufilmApplications" role="button" aria-expanded="false" aria-controls="hr">
                <i class="icon im im-icon-Gear"></i>
                <span class="item-name">প্রামান্যচিত্র অ্যাপ্লিকেশন</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('docufilmApplications*') ? 'show' : '' !!}" id="docufilmApplications"
                data-bs-parent="#sidebar-menu">
                @if (can('film_applications_index_list'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('docufilmApplications') ? 'active' : '' !!}"
                            href="{{ route('docufilmApplications.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> তা </i>
                            <span class="item-name">{{ __('messages.list') }}</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {!! Request::is('docufilmApplications_forward_table*') ? 'active' : '' !!}"
                        href="{{ route('docufilmApplications.forward.table') }}">
                        <i class="icon im im-icon-Settings-Window"></i>
                        <i class="sidenav-mini-icon"> অ </i>
                        <span class="item-name">{{ __('messages.pending_list') }}</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    {{-- রিয়েলিটি শো অ্যাপ্লিকেশন --}}
    @if (can('filmApplications_table'))
        <li class="nav-item">
            <a class="nav-link {!! Request::is('realityApplications*') || Request::is('reality-application*') ? 'active' : '' !!}" data-bs-toggle="collapse"
                href="#realityApplications" role="button" aria-expanded="false" aria-controls="hr">
                <i class="icon im im-icon-Gear"></i>
                <span class="item-name">রিয়েলিটি শো অ্যাপ্লিকেশন</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('realityApplications*') ? 'show' : '' !!}" id="realityApplications"
                data-bs-parent="#sidebar-menu">
                @if (can('film_applications_index_list'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('realityApplications') ? 'active' : '' !!}"
                            href="{{ route('realityApplications.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> তা </i>
                            <span class="item-name">{{ __('messages.list') }}</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {!! Request::is('realityApplications_forward_table*') ? 'active' : '' !!}"
                        href="{{ route('realityApplications.forward.table') }}">
                        <i class="icon im im-icon-Settings-Window"></i>
                        <i class="sidenav-mini-icon"> অ </i>
                        <span class="item-name">{{ __('messages.pending_list') }}</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    {{-- পার্টি অ্যাপ্লিকেশন --}}
    @if (can('filmApplications_table'))
        <li class="nav-item">
            <a class="nav-link {!! Request::is('partyApplications*') || Request::is('party-application*') ? 'active' : '' !!}" data-bs-toggle="collapse"
                href="#partyApplications" role="button" aria-expanded="false" aria-controls="hr">
                <i class="icon im im-icon-Gear"></i>
                <span class="item-name">পার্টি অ্যাপ্লিকেশন</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('partyApplications*') ? 'show' : '' !!}" id="partyApplications"
                data-bs-parent="#sidebar-menu">
                @if (can('film_applications_index_list'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('partyApplications') ? 'active' : '' !!}"
                            href="{{ route('partyApplications.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> তা </i>
                            <span class="item-name">{{ __('messages.list') }}</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {!! Request::is('partyApplications_forward_table*') ? 'active' : '' !!}"
                        href="{{ route('partyApplications.forward.table') }}">
                        <i class="icon im im-icon-Settings-Window"></i>
                        <i class="sidenav-mini-icon"> অ </i>
                        <span class="item-name">{{ __('messages.pending_list') }}</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    {{-- পেমেন্ট --}}
    @if (can('filmApplications_table'))
        <li class="nav-item">
            <a class="nav-link {!! Request::is('makePayments*') || Request::is('make-payment*') ? 'active' : '' !!}" data-bs-toggle="collapse" href="#makePayments" role="button" aria-expanded="false" aria-controls="hr">
                <i class="icon im im-icon-Gear"></i> <span class="item-name">পেমেন্ট</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('makePayments*') ? 'show' : '' !!}" id="makePayments"
                data-bs-parent="#sidebar-menu">
                @if (can('film_applications_index_list'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('makePayments') ? 'active' : '' !!}"
                            href="{{ route('makePayments.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> তা </i>
                            <span class="item-name">{{ __('messages.list') }}</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {!! Request::is('makePayments_forward_table*') ? 'active' : '' !!}"
                        href="{{ route('makePayments.forward.table') }}">
                        <i class="icon im im-icon-Settings-Window"></i>
                        <i class="sidenav-mini-icon"> অ </i>
                        <span class="item-name">{{ __('messages.pending_list') }}</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    @if (can('profile'))
        <li class="nav-item">
            <a class="nav-link {!! Request::is('profile') ? 'active' : '' !!}" aria-current="page" href="{{ url('/profile') }}">
                <i class="icon im im-icon-Home"></i>
                <span class="item-name">{{ __('messages.profile') }}</span>
            </a>
        </li>
    @endif

    @if (can('producers_table'))
        <li class="nav-item">
            <a class="nav-link {!! Request::is('producers*') ? 'active' : '' !!}" aria-current="page"
                href="{{ route('producers.index') }}">
                <i class="icon im im-icon-Gear"></i>
                <span class="item-name">{{ __('messages.producer') }}</span>
            </a>
        </li>
    @endif

    {{-- Leaves --}}
    @if (can('hr'))
        <li class="nav-item">
            <a class="nav-link {!! Request::is('leaves*') ? 'active' : '' !!}" data-bs-toggle="collapse" href="#hr"
                role="button" aria-expanded="false" aria-controls="hr">
                <i class="icon im im-icon-Gear"></i>
                <span class="item-name">{{ __('messages.human_resources') }}</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('leaves*') ? 'show' : '' !!}" id="hr" data-bs-parent="#sidebar-menu">
                @if (can('leaves'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('leaves*') ? 'active' : '' !!}" href="{{ route('leaves.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> ছু </i>
                            <span class="item-name">{{ __('messages.leave') }}</span>
                        </a>
                    </li>
                @endif
                @if (can('leave_apply_list'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('leave-apply-list') ? 'active' : '' !!}"
                            href="{{ route('leaves.apply.leave.list') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> ছু আ তা</i>
                            <span class="item-name">{{ __('messages.leave_application_list') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    {{-- ব্যবহারকারী ব্যবস্থাপনা --}}
    @if (can('user_management'))
        <li class="nav-item">
            <a class="nav-link {!! Request::is('users*') || Request::is('roleAndPermissions*') ? 'active' : '' !!}"
                data-bs-toggle="collapse" href="#users_menu" role="button" aria-expanded="false" aria-controls="users_menu">
                <i class="icon im im-icon-User"></i>
                <span class="item-name">{{ __('messages.user_management') }}</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('users*') || Request::is('roleAndPermissions*') ? 'show' : '' !!}"
                id="users_menu" data-bs-parent="#sidebar-menu">
                @if (can('user'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('users*') ? 'active' : '' !!}" href="{{ route('users.index') }}">
                            <i class="icon im im-icon-User"></i>
                            <i class="sidenav-mini-icon"> ব্য</i>
                            <span class="item-name">{{ __('messages.user') }}</span>
                        </a>
                    </li>
                @endif
                @if (can('roll_and_permission'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('roleAndPermissions*') ? 'active' : '' !!}"
                            href="{{ route('roleAndPermissions.index') }}">
                            <i class="icon im im-icon-Security-Settings"></i>
                            <i class="sidenav-mini-icon"> রো </i>
                            <span class="item-name">{{ __('messages.role_management') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('permissions*') ? 'active' : '' !!}"
                            href="{{ route('permissions.index') }}">
                            <i class="icon im im-icon-Security-Settings"></i>
                            <i class="sidenav-mini-icon"> অ </i>
                            <span class="item-name">অনুমতিসমূহ</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    {{-- ইনভেন্টরি --}}
    @if (can('inventory'))
        <li class="nav-item">
            <a class="nav-link {!! (Request::is('inventory*') ? 'active' : '') !!}" data-bs-toggle="collapse"
                href="#inventory_menu" role="button" aria-expanded="false" aria-controls="inventory_menu">
                <i class="icon im im-icon-Gear"></i>
                <span class="item-name">{{ __('messages.inventory') }}</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('inventory*') ? 'show' : '' !!}" id="inventory_menu"
                data-bs-parent="#sidebar-menu">
                @if (can('items'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('items*') ? 'active' : '' !!}" href="{{ route('items.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> আই </i>
                            <span class="item-name">{{ __('messages.item_list') }}</span>
                        </a>
                    </li>
                @endif
                @if (can('items'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('shifts*') ? 'active' : '' !!}" href="{{ route('shifts.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> শ </i>
                            <span class="item-name">{{ __('messages.shift') }}</span>
                        </a>
                    </li>
                @endif
                @if (can('item_categories'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('itemCategories*') ? 'active' : '' !!}"
                            href="{{ route('itemCategories.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> ক </i>
                            <span class="item-name">{{ __('messages.category') }}</span>
                        </a>
                    </li>
                @endif
                @if (can('item_units'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('itemUnits*') ? 'active' : '' !!}" href="{{ route('itemUnits.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> উ </i>
                            <span class="item-name">{{ __('messages.unit') }}</span>
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
                    Request::is('departments*') ||
                    Request::is('designations*')
                    ? 'active' : '') !!}" data-bs-toggle="collapse" href="#settings_menu" role="button"
                aria-expanded="false" aria-controls="settings_menu">
                <i class="icon im im-icon-Gear"></i>
                <span class="item-name">{{ __('messages.settings') }}</span>
                <i class="right-icon im im-icon-Arrow-Right"></i>
            </a>
            <ul class="sub-nav collapse {!! Request::is('siteSettings*') ||
                    Request::is('designations*') ||
                    Request::is('districts*') ||
                    Request::is('departments*')
                    ? 'show'
                    : '' !!}" id="settings_menu" data-bs-parent="#sidebar-menu">
                @if (can('site_settings'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('siteSettings*') ? 'active' : '' !!}"
                            href="{{ route('siteSettings.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> সি </i>
                            <span class="item-name">{{ __('messages.site_settings') }}</span>
                        </a>
                    </li>
                @endif
                @if (can('packages'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('packages*') ? 'active' : '' !!}" href="{{ route('packages.index') }}">
                            <i class="icon im im-icon-Settings-Window"></i>
                            <i class="sidenav-mini-icon"> প </i>
                            <span class="item-name">{{ __('messages.package') }}</span>
                        </a>
                    </li>
                @endif

                @if (can('designations'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('designations*') ? 'active' : '' !!}"
                            href="{{ route('designations.index') }}">
                            <i class="icon im im-icon-Teacher"></i>
                            <i class="sidenav-mini-icon"> ডি </i>
                            <span class="item-name">{{ __('messages.designation') }}</span>
                        </a>
                    </li>
                @endif
                @if (can('designations'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('departments*') ? 'active' : '' !!}"
                            href="{{ route('departments.index') }}">
                            <i class="icon im im-icon-Teacher"></i>
                            <i class="sidenav-mini-icon"> ডি </i>
                            <span class="item-name">{{ __('messages.department') }}</span>
                        </a>
                    </li>
                @endif
                @if (can('divisions'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('divisions*') ? 'active' : '' !!}" href="{{ route('divisions.index') }}">
                            <i class="icon im im-icon-Structure"></i>
                            <i class="sidenav-mini-icon"> বি </i>
                            <span class="item-name">{{ __('messages.division') }}</span>
                        </a>
                    </li>
                @endif

                @if (can('districts'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('districts*') ? 'active' : '' !!}" href="{{ route('districts.index') }}">
                            <i class="icon im im-icon-Structure"></i>
                            <i class="sidenav-mini-icon"> জে </i>
                            <span class="item-name">{{ __('messages.district') }}</span>
                        </a>
                    </li>
                @endif
                @if (can('upazilas'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('upazilas*') ? 'active' : '' !!}" href="{{ route('upazilas.index') }}">
                            <i class="icon im im-icon-Structure"></i>
                            <i class="sidenav-mini-icon"> উ </i>
                            <span class="item-name">{{ __('messages.upazila') }}</span>
                        </a>
                    </li>
                @endif
                @if (can('leave_type'))
                    <li class="nav-item">
                        <a class="nav-link {!! Request::is('leaveTypes*') ? 'active' : '' !!}"
                            href="{{ route('leaveTypes.index') }}">
                            <i class="icon im im-icon-Structure"></i>
                            <i class="sidenav-mini-icon"> ল </i>
                            <span class="item-name">{{ __('messages.leave_type') }}</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link {!! Request::is('approvalFlowMasters*') ? 'active' : '' !!}" href="{{ route('approvalFlowMasters.index') }}">
                        <i class="icon im im-icon-Structure"></i>
                        <i class="sidenav-mini-icon"> প্র </i>
                        <span class="item-name">অনুমোদন প্রবাহ</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {!! Request::is('approvalFlowSteps*') ? 'active' : '' !!}" href="{{ route('approvalFlowSteps.index') }}">
                        <i class="icon im im-icon-Structure"></i>
                        <i class="sidenav-mini-icon"> ধা </i>
                        <span class="item-name">অনুমোদন প্রবাহের ধাপ</span>
                    </a>
                </li>

            </ul>
        </li>
    @endif
@endif
