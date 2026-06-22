{{-- Mobile Topbar — only visible on small screens --}}
<div class="lg:hidden fixed top-0 left-0 right-0 z-30 bg-white shadow-sm h-14 flex items-center px-4">
    <button @click="sidebarOpen = !sidebarOpen"
            class="w-10 h-10 rounded-lg flex items-center justify-center text-gray-700 hover:bg-gray-100 transition-colors">
        <i class="bi bi-list text-xl"></i>
    </button>
    <span class="ml-3 font-semibold text-gray-800 text-sm">FaizFashion</span>
</div>
{{-- Spacer for mobile topbar --}}
<div class="lg:hidden h-14"></div>
