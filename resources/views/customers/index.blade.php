@extends('layouts.app')

@section('title', 'Customers Management')

@section('content')
    <div class="container-fluid p-4">

        {{-- Header Section --}}
        <div class="d-md-flex justify-content-between align-items-center mb-4">
            <div class="mb-3 mb-md-0">
                <h2 class="fw-bold text-dark mb-0">Hallo Admin</h2>
                <p class="text-muted small mb-0">Kelola dan filter data pelanggan Anda di sini.</p>
            </div>

            <div class="d-grid d-md-block">
                <button class="btn btn-primary shadow-sm px-4 fw-semibold" data-bs-toggle="modal"
                    data-bs-target="#modalTambahCustomer">
                    <i class="bi bi-person-fill-add me-2"></i>Tambah Customer
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4">

                <form action="{{ route('customers.index') }}" method="GET" class="mb-4">
                    <div class="row g-2 align-items-center">

                        <div class="col-12 col-md-4">
                            <div class="input-group">
                                <button type="submit"
                                    class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-decoration-none"
                                    style="cursor: pointer; border-right: 0;">
                                    <i class="bi bi-search text-muted"></i>
                                </button>
                                <input type="text" name="search"
                                    class="form-control bg-light border-start-0 rounded-end-pill" placeholder="Cari nama..."
                                    value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="col-6 col-md-3 col-lg-2 mt-3 mt-md-0">
                            <select name="gender" class="form-select bg-light border-0 rounded-pill"
                                onchange="this.form.submit()">
                                <option value="">Semua Gender</option>
                                <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        {{-- 3. Filter Kategori --}}
                        <div class="col-6 col-md-3 col-lg-2 mt-3 mt-md-0">
                            <select name="category" class="form-select bg-light border-0 rounded-pill"
                                onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                <option value="Atasan" {{ request('category') == 'Atasan' ? 'selected' : '' }}>Atasan
                                </option>
                                <option value="Bawahan" {{ request('category') == 'Bawahan' ? 'selected' : '' }}>Bawahan
                                </option>
                            </select>
                        </div>

                        {{-- 4. Tombol Reset (Muncul jika ada filter aktif) --}}
                        @if (request('search') || request('gender') || request('category'))
                            <div class="col-12 col-md-auto">
                                <a href="{{ route('customers.index') }}"
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
                                <th class="py-3">Nama Lengkap</th>
                                <th class="py-3 text-center">Gender</th>
                                <th class="py-3 text-center">Kategori</th>
                                <th class="py-3 text-center rounded-end-3" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $index => $customer)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $index + $customers->firstItem() }}</td>
                                    <td>
                                        <span class="fw-bold text-dark text-truncate">{{ $customer->name }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($customer->gender == 'L')
                                            <span class="badge bg-blue-soft text-blue rounded-pill px-3">
                                                <i class="bi bi-gender-male me-1"></i> Laki-laki
                                            </span>
                                        @else
                                            <span class="badge bg-pink-soft text-pink rounded-pill px-3">
                                                <i class="bi bi-gender-female me-1"></i> Perempuan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $catName = $customer->sizes->first()?->category?->nameCategory ?? '-';
                                        @endphp
                                        @if ($catName == 'Atasan')
                                            <span class="badge bg-purple-soft text-purple rounded-pill px-3">Atasan</span>
                                        @elseif($catName == 'Bawahan')
                                            <span class="badge bg-teal-soft text-teal rounded-pill px-3">Bawahan</span>
                                        @else
                                            <span
                                                class="badge bg-secondary-soft text-secondary rounded-pill px-3">{{ $catName }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('customers.show', $customer->id) }}"
                                                class="btn btn-action btn-soft-secondary" data-bs-toggle="tooltip"
                                                title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('customers.edit', $customer->id) }}"
                                                class="btn btn-action btn-soft-primary" data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="{{ route('customers.destroy', $customer->id) }}"
                                                class="btn btn-action btn-soft-danger" data-confirm-delete="true"
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="mb-3">
                                                <i class="bi bi-search fs-1 text-muted opacity-25"></i>
                                            </div>
                                            <h6 class="text-muted fw-bold">Data tidak ditemukan</h6>
                                            <p class="text-muted small mb-0">Coba ubah filter atau kata kunci pencarian
                                                Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="pagination-wrapper mt-4">
                    {{ $customers->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
@include('modalComponent.addCustomerModal')
