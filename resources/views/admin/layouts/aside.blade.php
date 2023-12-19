<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <li>
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route("admin.dashboard.index") }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <h6 class="sidebar-brand-text mx-3 mt-2 font-weight-bold">Store Keeper</h6>
        </a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs("admin.dashboard.index") ? "active" : "" }}">
        <a class="nav-link" href="{{ route("admin.dashboard.index") }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item {{
    request()->routeIs("admin.products.index") ||
    request()->routeIs("admin.products.create") ||
    request()->routeIs("admin.products.show") ||
    request()->routeIs("admin.products.edit")
    ? "active" : "" }}">
        <a class="nav-link" href="{{ route("admin.products.index") }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Products</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs("admin.sales.create") ? "active" : "" }}">
        <a class="nav-link" href="{{ route("admin.sales.create") }}">
            <i class="fas fa-fw fa-cart-plus"></i>
            <span>Sales</span>
        </a>
    </li>

    <li class="nav-item {{
    request()->routeIs("admin.sales.index") ||
    request()->routeIs("admin.sales.show")
    ? "active" : "" }}">
        <a class="nav-link" href="{{ route("admin.sales.index") }}">
            <i class="fas fa-fw fa-dollar-sign"></i>
            <span>Transactions</span>
        </a>
    </li>
</ul>
