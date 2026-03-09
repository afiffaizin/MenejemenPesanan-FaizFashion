@extends('layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
    <div class="container-fluid p-4">

        {{-- Header Section --}}
        <div class="d-md-flex justify-content-between align-items-center mb-4">
            <div class="mb-3 mb-md-0">
                <h2 class="fw-bold text-dark mb-0">Hallo Admin</h2>
                <p class="text-muted small mb-0">Kelola dan filter data pesanan Anda di sini.</p>
            </div>

            <div class="d-grid d-md-block">
                <button class="btn btn-primary shadow-sm px-4 fw-semibold" data-bs-toggle="modal"
                    data-bs-target="#modalTambahPesanan">
                    <i class="bi bi-cart-plus-fill me-2"></i>Tambah Pesanan
                </button>
            </div>
        </div>

        {{-- Content Card --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4">

                {{-- FILTER & SEARCH TOOLBAR --}}
                <form action="{{ route('orders.getOrders') }}" method="GET" class="mb-4">
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
                    </div>
                </form>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table align-middle custom-table table-striped table-bordered">
                        <thead class="bg-light-subtle text-secondary">
                            <tr>
                                <th class="py-3 rounded-start-3 text-center" width="5%">
                                    No</th>
                                <th class="py-3">No. Pesanan</th>
                                <th class="py-3">Nama Pelanggan</th>
                                <th class="py-3 text-center">Tanggal</th>
                                <th class="py-3 text-center">Status</th>
                                <th class="py-3 text-center rounded-end-3" width="15%">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $index => $order)
                                <tr>
                                    <td class="text-center fw-bold text-muted">
                                        {{ $index + $orders->firstItem() }}</td>
                                    <td>
                                        <span
                                            class="fw-bold text-dark">{{ $order->order_number ?? 'ORD-' . $order->id }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark text-truncate">{{ $order->customer->name ?? 'Pelanggan Dihapus' }}</span>
                                    </td>
                                    <td class="text-center text-muted">
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>
                                    <td class="text-center">

                                        <span class="badge bg-warning-soft text-warning rounded-pill px-3">
                                            {{ $order->status == 'Pending' ? 'Menunggu' : $order->status }}
                                        </span>

                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">


                                            <a href="{{ route('orders.destroy', $order->id) }}"
                                                class="btn btn-action btn-soft-danger" data-confirm-delete="true"
                                                data-bs-toggle="tooltip" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>

                                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST"
                                                class="form-selesai m-0 p-0">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-action btn-soft-primary"
                                                    data-confirm-selesai="true" data-bs-toggle="tooltip" title="Selesaikan">
                                                    <i class="bi bi-check2-square"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="mb-3">
                                                <i class="bi bi-cart-x fs-1 text-muted opacity-25"></i>
                                            </div>
                                            <h6 class="text-muted fw-bold">Data
                                                pesanan tidak ditemukan</h6>
                                            <p class="text-muted small mb-0">
                                                Coba ubah filter atau kata kunci pencarian Anda.</p>
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
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.querySelectorAll("[data-confirm-selesai]").forEach(function(button) {

                button.addEventListener("click", function(e) {

                    e.preventDefault();

                    let form = this.closest("form");

                    Swal.fire({
                        title: 'Selesaikan Pesanan!',
                        text: "Status akan diubah menjadi selesai!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Selesaikan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {

                        if (result.isConfirmed) {
                            form.submit();
                        }

                    });

                });

            });

        });
    </script>
@endpush
@include('modalComponent.addPesananModal')
