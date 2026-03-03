@extends('layouts.app')

@section('title', 'Detail Customer')

@section('content')
    {{-- Container dibuat d-flex agar card berada di tengah layar (vertikal & horizontal) --}}
    <div class="container-fluid p-4 d-flex justify-content-center align-items-start align-items-md-center"
        style="min-height: 80vh;">

        {{-- Card Detail - Diberi max-width agar tidak full screen dan terlihat seperti modal --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden w-100" style="max-width: 600px;">

            {{-- Header Card (Mirip Header Modal) --}}
            <div
                class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold text-dark mb-0">Detail Customer</h4>
                {{-- Tombol Close (X) untuk kembali ke index --}}
                <a href="{{ route('customers.index') }}" class="btn-close btn-close-white" aria-label="Close"
                    data-bs-toggle="tooltip" title="Tutup"></a>
            </div>

            {{-- Body Card --}}
            <div class="card-body p-4">

                {{-- Profil Singkat --}}
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-light-subtle text-primary border border-primary-subtle rounded-circle d-flex justify-content-center align-items-center fs-2 me-3"
                        style="width: 70px; height: 70px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">{{ $customer->name }}</h4>
                    </div>
                </div>

                <hr class="text-muted opacity-25 mb-4">

                {{-- Informasi Detail --}}
                <div class="row gy-3">
                    {{-- Gender --}}
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-semibold">Jenis Kelamin</span>
                        <div>
                            @if ($customer->gender == 'L')
                                <span class="badge bg-blue-soft text-blue rounded-pill px-3 py-2">
                                    <i class="bi bi-gender-male me-1"></i> Laki-laki
                                </span>
                            @else
                                <span class="badge bg-pink-soft text-pink rounded-pill px-3 py-2">
                                    <i class="bi bi-gender-female me-1"></i> Perempuan
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between align-items-center mt-3">
                        <span class="text-muted fw-semibold">No. Telepon</span>
                        <span class="text-dark fw-medium">{{ $customer->phone ?? '-' }}</span>
                    </div>
                    <div class="col-12 d-flex justify-content-between align-items-center mt-3">
                        <span class="text-muted fw-semibold">Alamat</span>
                        <span class="text-dark fw-medium">{{ $customer->address ?? '-' }}</span>
                    </div>

                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-semibold">Kategori </span>
                        <div>
                            @php
                                $catName = $customer->sizes->first()?->category?->nameCategory ?? '-';
                            @endphp
                            @if ($catName == 'Atasan')
                                <span class="badge bg-purple-soft text-purple rounded-pill px-3 py-2">Atasan</span>
                            @elseif($catName == 'Bawahan')
                                <span class="badge bg-teal-soft text-teal rounded-pill px-3 py-2">Bawahan</span>
                            @else
                                <span
                                    class="badge bg-secondary-soft text-secondary rounded-pill px-3 py-2">{{ $catName }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- Ukuran --}}
                    <div class="col-12 mt-3">
                        {{-- AMBIL DATA UKURAN PERTAMA --}}
                        @php
                            $size = $customer->sizes->first();
                        @endphp

                        <div class="ps-3 border-start border-2 border-primary">
                            {{-- Cek apakah ada data size --}}
                            @if ($size)
                                {{-- LOGIKA KATEGORI --}}
                                @if (($size->category->nameCategory ?? '') === 'atasan')
                                    <div class="row gy-2">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Panjang Baju</small>
                                            {{-- Perbaiki cara panggil variabel --}}
                                            <span class="text-dark fw-medium">{{ $size->panjang ?? '-' }} cm</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Lingkar Badan</small>
                                            <span class="text-dark fw-medium">{{ $size->lingkar_badan ?? '-' }} cm</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Lingkar Pinggang</small>
                                            <span class="text-dark fw-medium">{{ $size->lingkar_pinggang ?? '-' }} cm</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Lebar Punggung</small>
                                            <span class="text-dark fw-medium">{{ $size->punggung ?? '-' }} cm</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Panjang Lengan</small>
                                            <span class="text-dark fw-medium">{{ $size->panjang_lengan ?? '-' }} cm</span>
                                        </div>
                                    </div>
                                @else
                                    {{-- BAGIAN BAWAHAN --}}
                                    <div class="row gy-2">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Panjang (Cln/Rok)</small>
                                            <span class="text-dark fw-medium">{{ $size->panjang_pinggang ?? '-' }}
                                                cm</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Lingkar Pinggul</small>
                                            <span class="text-dark fw-medium">{{ $size->pinggul ?? '-' }} cm</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Pisak</small>
                                            <span class="text-dark fw-medium">{{ $size->pisak ?? '-' }} cm</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Pangkal Paha</small>
                                            <span class="text-dark fw-medium">{{ $size->pangkal_paha ?? '-' }} cm</span>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <p class="text-muted">Belum ada data ukuran.</p>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

            {{-- Footer Card (Mirip Footer Modal) --}}
            <div class="card-footer bg-light border-top-0 p-3 px-4 d-flex justify-content-end gap-2">
                <a href="{{ route('customers.index') }}"
                    class="btn btn-light text-secondary border shadow-sm px-4 fw-semibold">
                    Kembali
                </a>
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary shadow-sm px-4 fw-semibold">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data
                </a>
            </div>

        </div>
    </div>
@endsection
