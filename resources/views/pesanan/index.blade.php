@extends('layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
    <div class="p-4 md:p-6 lg:p-8">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Halo Admin</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola dan filter data pesanan Anda di sini.</p>
            </div>
            <button onclick="document.getElementById('modalTambahPesanan').classList.remove('hidden')"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
                <i class="bi bi-cart-plus-fill"></i>
                Tambah Pesanan
            </button>
        </div>

        {{-- Content Card --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 md:p-6">

                {{-- Search --}}
                <form action="{{ route('orders.getOrders') }}" method="GET" class="mb-5">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <div class="relative flex-1 max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search"
                                   class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Cari No. Pesanan atau Nama Pelanggan..." value="{{ request('search') }}">
                        </div>
                        <button type="submit"
                                class="px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('orders.getOrders') }}"
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
                                <th scope="col" class="px-4 py-4 font-semibold">No. Pesanan</th>
                                <th scope="col" class="px-4 py-4 font-semibold text-center">Tanggal</th>
                                <th scope="col" class="px-4 py-4 font-semibold text-center">Status</th>
                                <th scope="col" class="px-4 py-4 font-semibold text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100/80">
                            @forelse($orders as $index => $order)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-4 py-4 text-center text-gray-400 font-medium">
                                        {{ $index + $orders->firstItem() }}
                                    </td>
                                    
                                    {{-- Customer Avatar & Name --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            @php
                                                $name = $order->customer->name ?? 'Unknown';
                                                $initials = collect(explode(' ', $name))->map(fn($n) => substr($n, 0, 1))->take(2)->implode('');
                                            @endphp
                                            <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold border border-blue-100 flex-shrink-0">
                                                {{ strtoupper($initials) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-4 py-4 text-gray-600 font-medium">
                                        {{ $order->order_number ?? 'ORD-' . $order->id }}
                                    </td>
                                    
                                    <td class="px-4 py-4 text-center text-gray-500">
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                            {{ $order->status == 'Pending' ? 'Menunggu' : $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('orders.show', $order->id) }}"
                                               class="w-8 h-8 rounded-lg flex items-center justify-center bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white transition-all duration-200"
                                               title="Detail Pesanan">
                                                <i class="bi bi-eye text-sm"></i>
                                            </a>
                                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="m-0 p-0 inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200"
                                                        data-confirm-selesai="true" title="Selesaikan">
                                                    <i class="bi bi-check2-square text-sm"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('orders.destroy', $order->id) }}"
                                               class="w-8 h-8 rounded-lg flex items-center justify-center bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-200"
                                               data-confirm-delete="true" title="Hapus">
                                                <i class="bi bi-trash text-sm"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                                <i class="bi bi-cart-x text-2xl text-gray-400"></i>
                                            </div>
                                            <h3 class="text-sm font-semibold text-gray-900">Data pesanan tidak ditemukan</h3>
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
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Confirm "Selesaikan" with SweetAlert2
            document.querySelectorAll("[data-confirm-selesai]").forEach(function(button) {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    let form = this.closest("form");
                    Swal.fire({
                        title: 'Selesaikan Pesanan?',
                        text: "Status akan diubah menjadi selesai!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2563eb',
                        cancelButtonColor: '#ef4444',
                        confirmButtonText: 'Ya, Selesaikan!',
                        cancelButtonText: 'Batal',
                        customClass: {
                            popup: 'rounded-xl',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Confirm delete with SweetAlert2
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
                        customClass: {
                            popup: 'rounded-xl',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a form and submit DELETE
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

@include('modalComponent.addPesananModal')
