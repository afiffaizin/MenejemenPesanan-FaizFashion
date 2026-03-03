<aside class="app-sidebar" id="appSidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <img src="{{ asset('images/logo.svg') }}" alt="FaizFashion Logo" class="img-fluid">
        </div>
        <div class="brand-text">
            <span class="brand-name">FaizFashion</span>
            <span class="brand-tagline">Management System</span>
        </div>
        <button class="sidebar-close-btn" id="sidebarCloseBtn">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li>
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="bi bi-grid-1x2-fill"></i></span>
                    <span class="fs-6 fw-bold">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/customer') }}" class="nav-link {{ request()->is('customer') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="bi bi-people-fill"></i></span>
                    <span class="fs-6 fw-bold">Customers</span>
                </a>
            </li>

            <li class="nav-separator">Orders</li>

            <li>
                <a href="{{ route('orders.getOrders') }}" class="nav-link {{ request()->is('order') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="bi bi-plus-circle-fill"></i></span>
                    <span class="fs-6 fw-bold">Tambah Pesanan</span>
                </a>
            </li>


            <li>
                <a href="{{ route('orders.history') }}" class="nav-link {{ request()->is('orders/history') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="bi bi-clock-history"></i></span>
                    <span class="fs-6 fw-bold">History Pesanan</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <span class="nav-icon"><i class="bi bi-file-earmark-bar-graph-fill"></i></span>
                    <span class="fs-6 fw-bold">Laporan</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->name ?? 'Admin' }}</span>
                <span class="user-role">{{ auth()->user()->role ?? 'Admin' }}</span>
            </div>
        </div>

        <form method="POST" action="#">
            @csrf
            <button class="logout-btn" type="submit">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </div>
</aside>
