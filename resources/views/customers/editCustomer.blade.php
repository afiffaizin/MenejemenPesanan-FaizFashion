@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
    {{-- Container dibuat d-flex agar card berada di tengah layar (vertikal & horizontal) --}}
    <div class="container-fluid p-4 d-flex justify-content-center align-items-start align-items-md-center"
        style="min-height: 80vh;">

        {{-- Card Edit - Diberi max-width agar tidak full screen dan terlihat seperti modal --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden w-100" style="max-width: 600px;">

            {{-- Header Card --}}
            <div
                class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold text-dark mb-0">Edit Customer</h4>
                {{-- Tombol Close (X) untuk kembali ke index --}}
                <a href="{{ route('customers.index') }}" class="btn-close btn-close-white" aria-label="Close"
                    data-bs-toggle="tooltip" title="Batal"></a>
            </div>

            {{-- Form Wrapper --}}
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Body Card --}}
                <div class="card-body p-4">

                    {{-- Profil Singkat & Edit Nama --}}
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-light-subtle text-primary border border-primary-subtle rounded-circle d-flex justify-content-center align-items-center fs-2 me-3"
                            style="width: 70px; height: 70px; flex-shrink: 0;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="w-100">
                            <label for="name" class="form-label text-muted fw-semibold mb-1">Nama Customer <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control fw-bold"
                                value="{{ old('name', $customer->name) }}" required placeholder="Masukkan nama customer">
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 mb-4">

                    {{-- Informasi Detail (Form Inputs) --}}
                    <div class="row gy-3">
                        {{-- Gender --}}
                        <div class="col-12">
                            <label for="gender" class="form-label text-muted fw-semibold">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="" disabled>Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('gender', $customer->gender) == 'L' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="P" {{ old('gender', $customer->gender) == 'P' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>

                        {{-- No. Telepon --}}
                        <div class="col-12 mt-3">
                            <label for="phone" class="form-label text-muted fw-semibold">No. Telepon</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                value="{{ old('phone', $customer->phone) }}" placeholder="Contoh: 08123456789">
                        </div>

                        {{-- Alamat --}}
                        <div class="col-12 mt-3">
                            <label for="address" class="form-label text-muted fw-semibold">Alamat</label>
                            <textarea name="address" id="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap">{{ old('address', $customer->address) }}</textarea>
                        </div>

                        {{-- Kategori (Readonly - Biasanya kategori ukuran tidak diubah sembarangan di form edit biodata, tapi ditampilkan sebagai info) --}}
                        <div class="col-12 mt-3">
                            <label class="form-label text-muted fw-semibold">Kategori Pakaian</label>
                            <div>
                                @php
                                    $catName = $customer->sizes->first()?->category?->nameCategory ?? '-';
                                @endphp
                                <input type="text" class="form-control bg-light" value="{{ $catName }}" readonly
                                    disabled>
                            </div>
                        </div>

                        {{-- Ukuran --}}
                        <div class="col-12 mt-3">
                            <label class="form-label text-muted fw-semibold">Detail Ukuran (cm)</label>

                            @php
                                $size = $customer->sizes->first();
                            @endphp

                            <div class="ps-3 border-start border-2 border-primary mt-2">
                                @if ($size)
                                    {{-- Hidden input untuk mengirimkan ID size yang sedang di-edit --}}
                                    <div class="row gy-3">
                                        <div class="col-6">
                                            <label class="form-label small text-muted mb-1">Panjang Baju</label>
                                            <input type="number" step="0.1" name="panjang"
                                                class="form-control form-control-sm"
                                                value="{{ old('panjang', $size->panjang) }}">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small text-muted mb-1">Lingkar Badan</label>
                                            <input type="number" step="0.1" name="lingkar_badan"
                                                class="form-control form-control-sm"
                                                value="{{ old('lingkar_badan', $size->lingkar_badan) }}">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small text-muted mb-1">Lingkar Pinggang</label>
                                            <input type="number" step="0.1" name="lingkar_pinggang"
                                                class="form-control form-control-sm"
                                                value="{{ old('lingkar_pinggang', $size->lingkar_pinggang) }}">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small text-muted mb-1">Lebar Punggung</label>
                                            <input type="number" step="0.1" name="punggung"
                                                class="form-control form-control-sm"
                                                value="{{ old('punggung', $size->punggung) }}">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small text-muted mb-1">Panjang Lengan</label>
                                            <input type="number" step="0.1" name="panjang_lengan"
                                                class="form-control form-control-sm"
                                                value="{{ old('panjang_lengan', $size->panjang_lengan) }}">
                                        </div>
                                    </div>
                                @else
                                    <div class="row gy-3">
                                        <div class="col-6">
                                            <label class="form-label small text-muted mb-1">Panjang (Cln/Rok)</label>
                                            <input type="number" step="0.1" name="panjang_pinggang"
                                                class="form-control form-control-sm"
                                                value="{{ old('panjang_pinggang', $size->panjang_pinggang) }}">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small text-muted mb-1">Lingkar Pinggul</label>
                                            <input type="number" step="0.1" name="pinggul"
                                                class="form-control form-control-sm"
                                                value="{{ old('pinggul', $size->pinggul) }}">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small text-muted mb-1">Pisak</label>
                                            <input type="number" step="0.1" name="pisak"
                                                class="form-control form-control-sm"
                                                value="{{ old('pisak', $size->pisak) }}">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small text-muted mb-1">Pangkal Paha</label>
                                            <input type="number" step="0.1" name="pangkal_paha"
                                                class="form-control form-control-sm"
                                                value="{{ old('pangkal_paha', $size->pangkal_paha) }}">
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer Card (Action Buttons) --}}
                <div class="card-footer bg-light border-top-0 p-3 px-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('customers.index') }}"
                        class="btn btn-light text-secondary border shadow-sm px-4 fw-semibold">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm px-4 fw-semibold">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
