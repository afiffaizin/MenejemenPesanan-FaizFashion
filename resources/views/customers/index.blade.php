@extends('layouts.app')

@section('title', 'Customers Management')

@section('content')
    <div class="p-4 md:p-6 lg:p-8">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Halo Admin</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola dan filter data pelanggan Anda di sini.</p>
            </div>
            <button onclick="document.getElementById('modalTambahCustomer').classList.remove('hidden')"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
                <i class="bi bi-person-fill-add"></i>
                Tambah Customer
            </button>
        </div>

        {{-- Content Card --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 md:p-6">

                {{-- Filter & Search --}}
                <form action="{{ route('customers.index') }}" method="GET" class="mb-5">
                    <div class="flex flex-col sm:flex-row gap-2 flex-wrap">
                        {{-- Search --}}
                        <div class="relative flex-1 min-w-[200px] max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search"
                                   class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Cari nama..." value="{{ request('search') }}">
                        </div>

                        {{-- Gender Filter --}}
                        <select name="gender" onchange="this.form.submit()"
                                class="px-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Semua Gender</option>
                            <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>

                        {{-- Category Filter --}}
                        <select name="category" onchange="this.form.submit()"
                                class="px-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Semua Kategori</option>
                            <option value="Atasan" {{ request('category') == 'Atasan' ? 'selected' : '' }}>Atasan</option>
                            <option value="Bawahan" {{ request('category') == 'Bawahan' ? 'selected' : '' }}>Bawahan</option>
                        </select>

                        <button type="submit"
                                class="px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            Cari
                        </button>

                        @if(request('search') || request('gender') || request('category'))
                            <a href="{{ route('customers.index') }}"
                               class="px-4 py-2.5 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors inline-flex items-center gap-1">
                                <i class="bi bi-x-circle"></i> Reset
                            </a>
                        @endif
                    </div>
                </form>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-transparent border-b border-gray-200">
                            <tr>
                                <th scope="col" class="px-4 py-4 font-semibold w-12 text-center">No</th>
                                <th scope="col" class="px-4 py-4 font-semibold">Customer</th>
                                <th scope="col" class="px-4 py-4 font-semibold">Gender</th>
                                <th scope="col" class="px-4 py-4 font-semibold">Kategori Ukuran</th>
                                <th scope="col" class="px-4 py-4 font-semibold text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100/80">
                            @forelse($customers as $index => $customer)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-4 py-4 text-center text-gray-400 font-medium">
                                        {{ $index + $customers->firstItem() }}
                                    </td>
                                    
                                    {{-- Customer Avatar & Name --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            @php
                                                $initials = collect(explode(' ', $customer->name))->map(fn($n) => substr($n, 0, 1))->take(2)->implode('');
                                            @endphp
                                            <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold border border-blue-100 flex-shrink-0">
                                                {{ strtoupper($initials) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $customer->name }}</span>
                                                <span class="text-xs text-gray-400">{{ $customer->phone ?? 'No phone' }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Gender --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-1.5">
                                            @if($customer->gender == 'L')
                                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                                <span class="text-gray-600 font-medium">Laki-laki</span>
                                            @else
                                                <span class="w-2 h-2 rounded-full bg-pink-500"></span>
                                                <span class="text-gray-600 font-medium">Perempuan</span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Categories --}}
                                    <td class="px-4 py-4">
                                        <div class="flex flex-wrap gap-1.5">
                                            @forelse($customer->sizes as $size)
                                                @php $catName = strtolower($size->category->nameCategory ?? ''); @endphp
                                                @if($catName == 'atasan')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">Atasan</span>
                                                @elseif($catName == 'bawahan')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-teal-50 text-teal-700 border border-teal-100">Bawahan</span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-50 text-gray-600 border border-gray-200">{{ $size->category->nameCategory ?? 'Unknown' }}</span>
                                                @endif
                                            @empty
                                                <span class="text-gray-400 italic text-xs">Belum ada</span>
                                            @endforelse
                                        </div>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('customers.show', $customer->id) }}"
                                               class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200"
                                               title="Detail">
                                                <i class="bi bi-eye text-sm"></i>
                                            </a>
                                            <a href="{{ route('customers.edit', $customer->id) }}"
                                               class="w-8 h-8 rounded-lg flex items-center justify-center bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-all duration-200"
                                               title="Edit">
                                                <i class="bi bi-pencil-square text-sm"></i>
                                            </a>
                                            <a href="{{ route('customers.destroy', $customer->id) }}"
                                               class="w-8 h-8 rounded-lg flex items-center justify-center bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-200"
                                               data-confirm-delete="true" title="Hapus">
                                                <i class="bi bi-trash text-sm"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                                <i class="bi bi-inbox text-2xl text-gray-400"></i>
                                            </div>
                                            <h3 class="text-sm font-semibold text-gray-900">Data tidak ditemukan</h3>
                                            <p class="text-xs text-gray-500 mt-1 max-w-sm">Coba ubah kata kunci pencarian atau bersihkan filter Anda untuk melihat lebih banyak hasil.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="pagination-wrapper">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll("[data-confirm-delete]").forEach(function(link) {
            link.addEventListener("click", function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: { popup: 'rounded-xl' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush

@include('modalComponent.addCustomerModal')
