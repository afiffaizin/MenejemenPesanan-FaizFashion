@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
    <div class="container-fluid p-4">

        {{-- Header Section --}}
        <div class="d-md-flex justify-content-between align-items-center mb-4">
            <div class="mb-3 mb-md-0">
                <h2 class="fw-bold text-dark mb-0">Riwayat Pesanan</h2>
                <p class="text-muted small mb-0">Lihat semua data pesanan yang telah selesai.</p>
            </div>

            {{-- Tombol Kembali ke Dashboard --}}
            <div class="d-grid d-md-block">
                <a href="{{ route('orders.getOrders') }}" class="btn btn-outline-secondary shadow-sm px-4 fw-semibold">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Pesanan
                </a>
            </div>
        </div>

        {{-- Content Card --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4">

                {{-- FILTER & SEARCH TOOLBAR --}}
                <form action="{{ route('orders.history') }}" method="GET" class="mb-4">
                    <div class="row g-2 align-items-center">

                        {{-- 1. Search Bar --}}
                        <div class="col-12 col-md-5">
                            <div class="input-group">
                                <button type="submit"
                                    class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-decoration-none"
                                    style="cursor: pointer; border-right: 0;">
                                    <i class="bi bi-search text-muted"></i>
                                </button>
                                <input type="text" name="search"
                                    class="form-control bg-light border-start-0 rounded-end-pill"
                                    placeholder="Cari No. Pesanan atau Nama Pelanggan..." value="{{ request('search') }}">
                            </div>
                        </div>

                        {{-- Tombol Reset (Muncul jika ada pencarian) --}}
                        @if (request('search'))
                            <div class="col-12 col-md-auto mt-3 mt-md-0">
                                <a href="{{ route('orders.history') }}"
                                    class="btn btn-light text-danger rounded-pill w-100 border-0">
                                    <i class="bi bi-x-circle me-1"></i> Reset
                                </a>
                            </div>
                        @endif
                    </div>
                </form>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table align-middle custom-table table-striped table-bordered">
                        <thead class="bg-light-subtle text-secondary">
                            <tr>
                                <th class="py-3 rounded-start-3 text-center" width="5%">No</th>
                                <th class="py-3">No. Pesanan</th>
                                <th class="py-3">Nama Pelanggan</th>
                                <th class="py-3 text-center">Tanggal Pinjam</th>
                                <th class="py-3 text-center">Tanggal Selesai</th>
                                <th class="py-3 text-center rounded-end-3" width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $index => $order)
                                <tr>
                                    <td class="text-center fw-bold text-muted">
                                        {{ $index + $orders->firstItem() }}
                                    </td>
                                    <td>
                                        <span
                                            class="fw-bold text-dark">{{ $order->order_number ?? 'ORD-' . $order->id }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark text-truncate">{{ $order->customer->name ?? 'Pelanggan Dihapus' }}</span>
                                    </td>
                                    <td class="text-center text-muted">
                                        {{-- Asumsi menggunakan created_at sebagai tanggal pinjam --}}
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>
                                    <td class="text-center text-muted">
                                        {{-- Asumsi menggunakan updated_at sebagai tanggal selesai --}}
                                        {{ $order->updated_at->format('d M Y') }}
                                    </td>
                                    <td class="text-center">
                                        {{-- Karena ini halaman history, diasumsikan semuanya selesai --}}
                                        <span class="badge bg-success-soft text-success rounded-pill px-3">
                                            Selesai
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="mb-3">
                                                <i class="bi bi-archive fs-1 text-muted opacity-25"></i>
                                            </div>
                                            <h6 class="text-muted fw-bold">Belum ada riwayat pesanan</h6>
                                            <p class="text-muted small mb-0">Pesanan yang sudah selesai akan tampil di sini.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="pagination-wrapper mt-4">
                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
