<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 w-64 bg-sidebar-bg flex flex-col transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:z-30">

    {{-- Brand / Logo --}}
    <div class="flex items-center gap-3 px-5 py-5 border-b border-sidebar-border flex-shrink-0">
        <div class="w-10 h-10 flex items-center justify-center flex-shrink-0">
            <img src="{{ asset('images/logo.svg') }}" alt="FaizFashion Logo" class="w-full h-full object-contain">
        </div>
        <div class="flex flex-col leading-tight overflow-hidden">
            <span class="text-sm font-bold text-sidebar-text-bright tracking-wide truncate">FaizFashion</span>
            <span class="text-[0.65rem] font-medium text-sidebar-text tracking-wide truncate">Management System</span>
        </div>
        {{-- Close button (mobile) --}}
        <button @click="sidebarOpen = false"
                class="ml-auto lg:hidden w-7 h-7 rounded flex items-center justify-center text-sidebar-text border border-sidebar-border hover:bg-sidebar-hover hover:text-sidebar-text-bright transition-colors">
            <i class="bi bi-x-lg text-xs"></i>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-3 sidebar-scroll">
        <ul class="space-y-0.5 px-3">
            {{-- Dashboard --}}
            <li>
                <a href="{{ url('/dashboard') }}"
                   class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 nav-link-gradient
                          {{ request()->is('dashboard') ? 'bg-sidebar-active text-white border-l-[3px] border-blue-400 pl-3' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-sidebar-text-bright hover:pl-4' }}">
                    <span class="w-5 flex items-center justify-center text-base"><i class="bi bi-grid-1x2-fill"></i></span>
                    <span class="font-semibold">Dashboard</span>
                </a>
            </li>

            {{-- Customers --}}
            <li>
                <a href="{{ url('/customer') }}"
                   class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 nav-link-gradient
                          {{ request()->is('customer') || request()->is('customer/*') ? 'bg-sidebar-active text-white border-l-[3px] border-blue-400 pl-3' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-sidebar-text-bright hover:pl-4' }}">
                    <span class="w-5 flex items-center justify-center text-base"><i class="bi bi-people-fill"></i></span>
                    <span class="font-semibold">Customers</span>
                </a>
            </li>

            {{-- Separator --}}
            <li class="pt-4 pb-1.5 px-3">
                <span class="text-[0.65rem] font-bold uppercase tracking-[1.5px] text-sidebar-text">Orders</span>
            </li>

            {{-- Tambah Pesanan --}}
            <li>
                <a href="{{ route('orders.getOrders') }}"
                   class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 nav-link-gradient
                          {{ request()->is('order') ? 'bg-sidebar-active text-white border-l-[3px] border-blue-400 pl-3' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-sidebar-text-bright hover:pl-4' }}">
                    <span class="w-5 flex items-center justify-center text-base"><i class="bi bi-plus-circle-fill"></i></span>
                    <span class="font-semibold">Tambah Pesanan</span>
                </a>
            </li>

            {{-- History Pesanan --}}
            <li>
                <a href="{{ route('orders.history') }}"
                   class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 nav-link-gradient
                          {{ request()->is('orders/history') ? 'bg-sidebar-active text-white border-l-[3px] border-blue-400 pl-3' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-sidebar-text-bright hover:pl-4' }}">
                    <span class="w-5 flex items-center justify-center text-base"><i class="bi bi-clock-history"></i></span>
                    <span class="font-semibold">History Pesanan</span>
                </a>
            </li>

            {{-- Laporan --}}
            <li>
                <a href="#"
                   class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 nav-link-gradient text-sidebar-text hover:bg-sidebar-hover hover:text-sidebar-text-bright hover:pl-4">
                    <span class="w-5 flex items-center justify-center text-base"><i class="bi bi-file-earmark-bar-graph-fill"></i></span>
                    <span class="font-semibold">Laporan</span>
                </a>
            </li>
        </ul>
    </nav>

    {{-- Footer / User Profile --}}
    <div class="flex items-center gap-3 px-4 py-3.5 border-t border-sidebar-border flex-shrink-0 bg-corporate-950/50">
        <div class="w-9 h-9 rounded-full bg-blue-500 text-white text-sm font-bold flex items-center justify-center flex-shrink-0">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>
        <div class="flex flex-col leading-tight overflow-hidden flex-1 min-w-0">
            <span class="text-xs font-semibold text-sidebar-text-bright truncate">{{ auth()->user()->name ?? 'Admin' }}</span>
            <span class="text-[0.65rem] text-sidebar-text truncate capitalize">{{ auth()->user()->role ?? 'Admin' }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-8 h-8 rounded flex items-center justify-center text-sidebar-text border border-sidebar-border hover:bg-red-500/15 hover:border-red-500/40 hover:text-red-400 transition-colors"
                    title="Logout">
                <i class="bi bi-box-arrow-right text-sm"></i>
            </button>
        </form>
    </div>
</aside>
