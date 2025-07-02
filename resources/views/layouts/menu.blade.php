<li class="{!! (Request::is('leaves*') ? 'active' : '' ) !!}">
    <a href="{{ route('leaves.index') }}">
        <span class="mm-text ">Leaves</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('departments*') ? 'active' : '' ) !!}">
    <a href="{{ route('departments.index') }}">
        <span class="mm-text ">Departments</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('leaveTypes*') ? 'active' : '' ) !!}">
    <a href="{{ route('leaveTypes.index') }}">
        <span class="mm-text ">Leave Types</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

