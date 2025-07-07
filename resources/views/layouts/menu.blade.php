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

<li class="{!! (Request::is('producers*') ? 'active' : '' ) !!}">
    <a href="{{ route('producers.index') }}">
        <span class="mm-text ">Producers</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('itemUnits*') ? 'active' : '' ) !!}">
    <a href="{{ route('itemUnits.index') }}">
        <span class="mm-text ">Item Units</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('itemCategories*') ? 'active' : '' ) !!}">
    <a href="{{ route('itemCategories.index') }}">
        <span class="mm-text ">Item Categories</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

<li class="{!! (Request::is('items*') ? 'active' : '' ) !!}">
    <a href="{{ route('items.index') }}">
        <span class="mm-text ">Items</span>
        <span class="menu-icon"><i class="im im-icon-Structure"></i></span>
    </a>
</li>

