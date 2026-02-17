<li class="{!! (Request::is('leaves*') ? 'active' : '' ) !!}">
    <a href="{{ route('leaves.index') }}">
        <span class="mm-text ">{{ __('messages.leaves') }}</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('departments*') ? 'active' : '' ) !!}">
    <a href="{{ route('departments.index') }}">
        <span class="mm-text ">{{ __('messages.departments') }}</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('leaveTypes*') ? 'active' : '' ) !!}">
    <a href="{{ route('leaveTypes.index') }}">
        <span class="mm-text ">{{ __('messages.leave_type') }}</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('producers*') ? 'active' : '' ) !!}">
    <a href="{{ route('producers.index') }}">
        <span class="mm-text ">{{ __('messages.producers') }}</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('itemUnits*') ? 'active' : '' ) !!}">
    <a href="{{ route('itemUnits.index') }}">
        <span class="mm-text ">{{ __('messages.item_units') }}</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('itemCategories*') ? 'active' : '' ) !!}">
    <a href="{{ route('itemCategories.index') }}">
        <span class="mm-text ">{{ __('messages.item_categories') }}</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('items*') ? 'active' : '' ) !!}">
    <a href="{{ route('items.index') }}">
        <span class="mm-text ">{{ __('messages.items_label') }}</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('divisions*') ? 'active' : '' ) !!}">
    <a href="{{ route('divisions.index') }}">
        <span class="mm-text ">{{ __('messages.divisions') }}</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('packages*') ? 'active' : '' ) !!}">
    <a href="{{ route('packages.index') }}">
        <span class="mm-text ">{{ __('messages.packages') }}</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('filmApplications*') ? 'active' : '' ) !!}">
    <a href="{{ route('filmApplications.index') }}">
        <span class="mm-text ">{{ __('messages.film_applications_label') }}</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('shifts*') ? 'active' : '' ) !!}">
    <a href="{{ route('shifts.index') }}">
        <span class="mm-text ">{{ __('messages.shifts') }}</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('approvalFlowMasters*') ? 'active' : '' ) !!}">
    <a href="{{ route('approvalFlowMasters.index') }}">
        <span class="mm-text ">Approval Flow Masters</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('approvalFlowSteps*') ? 'active' : '' ) !!}">
    <a href="{{ route('approvalFlowSteps.index') }}">
        <span class="mm-text ">Approval Flow Steps</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('approvalRequests*') ? 'active' : '' ) !!}">
    <a href="{{ route('approvalRequests.index') }}">
        <span class="mm-text ">Approval Requests</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('approvalLogs*') ? 'active' : '' ) !!}">
    <a href="{{ route('approvalLogs.index') }}">
        <span class="mm-text ">Approval Logs</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

