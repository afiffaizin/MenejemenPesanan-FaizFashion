<form method="POST" action="{{ route('customers.store') }}">
    @csrf

    <input type="hidden" name="customerType" value="new">

    <div class="modal fade" id="modalTambahCustomer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content custom-modal-content">

                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-plus me-2"></i>Tambah Customer Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="custom-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama Customer..."
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="custom-label">Gender</label>
                            <select class="form-select" name="gender">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="custom-label">Nomor Telephone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Nomor telephone...">
                        </div>
                        <div class=" col-md-6">
                            <label class="custom-label">Alamat</label>
                            <textarea class="form-control" name="address" placeholder="Alamat lengkap..."></textarea>
                        </div>

                        <div class="col-12 mt-4">
                            <label class="custom-label d-block mb-2">Kategori Ukuran Awal</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="nameCategory" value="Atasan"
                                        id="catAtasanCustomer" onchange="toggleInputs()" checked>
                                    <label class="form-check-label" for="catAtasanCustomer">Atasan</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="nameCategory" value="Bawahan"
                                        id="catBawahanCustomer" onchange="toggleInputs()">
                                    <label class="form-check-label" for="catBawahanCustomer">Bawahan</label>
                                </div>
                            </div>
                        </div>


                        <div id="inputAtasanCustomer" class="col-12">
                            <div class="measurement-area">
                                <span class="measurement-badge">Form Ukuran Atasan</span>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="small text-muted fw-bold">Panjang Baju</label>
                                        <input type="number" name="panjang" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="small text-muted fw-bold">Lingkar Badan</label>
                                        <input type="number" name="lingkar_badan" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="small text-muted fw-bold">Lingkar Pinggang</label>
                                        <input type="number" name="lingkar_pinggang"
                                            class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="small text-muted fw-bold">Lebar Punggung</label>
                                        <input type="number" name="punggung" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="small text-muted fw-bold">Panjang Lengan</label>
                                        <input type="number" name="panjang_lengan"
                                            class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="inputBawahanCustomer" class="col-12 d-none">
                            <div class="measurement-area">
                                <span class="measurement-badge">Form Ukuran
                                    Bawahan</span>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small text-muted fw-bold">Panjang (Cln/Rok)</label>
                                        <input type="number" name="panjang_pinggang"
                                            class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted fw-bold">Lingkar Pinggul</label>
                                        <input type="number" name="pinggul" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted fw-bold">Pisak (Crotch)</label>
                                        <input type="number" name="pisak" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted fw-bold">Pangkal Paha</label>
                                        <input type="number" name="pangkal_paha"
                                            class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-link text-decoration-none text-muted"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-simpan shadow"><i class="bi bi-save me-2"></i>Simpan
                        Customer</button>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        function toggleInputs() {
            const isAtasan = document.getElementById('catAtasanCustomer').checked;
            const divAtasan = document.getElementById('inputAtasanCustomer');
            const divBawahan = document.getElementById('inputBawahanCustomer');

            if (isAtasan) {
                divAtasan.classList.remove('d-none');
                divBawahan.classList.add('d-none');
            } else {
                divAtasan.classList.add('d-none');
                divBawahan.classList.remove('d-none');
            }
        }
    </script>
@endpush
