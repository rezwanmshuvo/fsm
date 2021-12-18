<!-- Product -->
<li class="nav-item nav-item-submenu {{ (request()->is('items*') || request()->is('item-categories*') || request()->is('godowns*') || request()->is('blocks*') || request()->is('vehicles*')) ? 'nav-item-open':'' }}">
    <a href="#" class="nav-link"><i class="icon-grid6"></i> <span>Product</span></a>
    <ul class="nav nav-group-sub" data-submenu-title="Level One" {{ (request()->is('items*') || request()->is('item-categories*') || request()->is('godowns*') || request()->is('blocks*') || request()->is('vehicles*')) ? 'style=display:block;':'' }}>
        <li class="nav-item">
            <a href="{{ route('items.index') }}" class="nav-link {{ (request()->is('items*')) ? 'active':'' }}">
                <i class="icon-width"></i>
                <span>Items</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('item-categories.index') }}" class="nav-link {{ (request()->is('item-categories*')) ? 'active':'' }}">
                <i class="icon-width"></i>
                <span>Item Categories</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('vehicles.index') }}" class="nav-link {{ (request()->is('vehicles*')) ? 'active':'' }}">
                <i class="icon-width"></i>
                <span>Vehicles</span>
            </a>
        </li>
    </ul>
</li>

<!-- People -->
<li class="nav-item nav-item-submenu">
    <a href="#" class="nav-link"><i class="icon-grid6"></i> <span>People</span></a>
    <ul class="nav nav-group-sub" data-submenu-title="Level One">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="icon-width"></i>
                <span>Customers</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="icon-width"></i>
                <span>Party/Supplier</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="icon-width"></i>
                <span>Employees</span>
            </a>
        </li>
    </ul>
</li>

<!-- Processing -->
<li class="nav-item nav-item-submenu">
    <a href="#" class="nav-link"><i class="icon-grid6"></i> <span>Processing</span></a>
    <ul class="nav nav-group-sub" data-submenu-title="Level One">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="icon-width"></i>
                <span>Pre-Purchase</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="icon-width"></i>
                <span>Purchase</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="icon-width"></i>
                <span>Production (Crash)</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="icon-width"></i>
                <span>Receiving</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="icon-width"></i>
                <span>Sales</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="icon-width"></i>
                <span>Bags</span>
            </a>
        </li>
    </ul>
</li>
