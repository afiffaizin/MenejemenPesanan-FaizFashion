@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid p-4">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center pb-2 mb-4">

            <div class="mb-3 mb-md-0 flex-grow-1">
                <h2 class="fw-bold text-dark mb-0">Dashboard</h2>
                <p class="text-muted small mb-0 text-nowrap">Halo Admin, berikut ringkasan butik hari ini.</p>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end w-100 w-md-auto">
                <button class="btn btn-white border bg-white shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#modalTambahCustomer">
                    <i class="bi bi-person-fill-add"></i> Tambah Customer
                </button>

                <button class="btn btn-primary shadow-sm fw-semibold" data-bs-toggle="modal"
                    data-bs-target="#modalTambahPesanan">
                    <i class="bi bi-plus-lg me-1"></i> Pesanan Baru
                </button>
            </div>
        </div>



        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Card --}}
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon rose"><i class="bi bi-people"></i></div>
                    <div>
                        <div class="stat-value fw-bold fs-4 ">{{ $totalCustomers }}</div>
                        <div class="stat-label">Total Customers</div>
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon amber"><i class="bi bi-hourglass-split"></i></div>
                    <div>
                        <div class="stat-value fw-bold fs-4 ">{{ $pendingOrders }}</div>
                        <div class="stat-label">Antrian Jahit</div>
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="bi bi-check2-all"></i></div>
                    <div>
                        <div class="stat-value fw-bold fs-4 ">{{ $orderanSelesai }}</div>
                        <div class="stat-label">Selesai</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="bi bi-receipt"></i></div>
                    <div>
                        <div class="stat-value fw-bold fs-4 ">{{ $totalOrderan }}</div>
                        <div class="stat-label">Total Orderan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('modalComponent.addPesananModal')
@include('modalComponent.addCustomerModal')
