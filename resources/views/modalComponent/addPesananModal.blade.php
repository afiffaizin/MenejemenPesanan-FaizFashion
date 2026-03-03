<form method="POST" action="{{ route('orders.store') }}" id="formAddOrder" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="modalTambahPesanan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content custom-modal-content">

                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-bag-plus me-2"></i>Tambah Pesanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Validation Error Alert -->
                <div id="alertError" class="alert alert-danger alert-dismissible fade show d-none m-4 mb-0"
                    role="alert">
                    <span id="errorContent"></span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">

                    <div class="text-center">
                        <div class="toggle-wrapper">
                            <input type="radio" class="btn-check" name="customerType" id="typeExisting"
                                value="existing" checked onchange="toggleCustomerType()">
                            <label class="btn-toggle-option" for="typeExisting">Pelanggan Lama</label>

                            <input type="radio" class="btn-check" name="customerType" id="typeNew" value="new"
                                onchange="toggleCustomerType()">
                            <label class="btn-toggle-option" for="typeNew">Pelanggan Baru</label>
                        </div>
                    </div>

                    <div id="sectionExisting" class="fade show">
                        <div class="mb-3">
                            <label class="custom-label">Cari Nama Pelanggan <span class="text-danger">*</span></label>
                            <select id="selectPelanggan" name="customer_id" class="form-select">
                                <option value="" selected disabled>-- Pilih Pelanggan --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <small class="text-danger d-block mt-1"><i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Loading Indicator -->
                        <div id="loadingSizeExisting" class="d-none mt-3">
                            <div class="text-center">
                                <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <small class="text-muted">Memuat data ukuran...</small>
                            </div>
                        </div>

                        <!-- Display Sizes Information -->
                        <div id="displaySizeExisting" class="info-box d-none mt-3">
                            <h6 class="fw-bold mb-3"><i class="bi bi-ruler me-2"></i>Pilih Ukuran <span
                                    class="text-danger">*</span></h6>
                            <hr class="my-2">
                            <div id="textUkuranExisting">-</div>
                        </div>

                        <!-- Error Message -->
                        <div id="errorSizeExisting" class="alert alert-info d-none mt-3" role="alert">
                            <i class="bi bi-info-circle me-2"></i>
                            <span id="errorMessage"></span>
                        </div>

                        @error('size_id')
                            <small class="text-danger d-block mt-2"><i class="bi bi-exclamation-circle"></i>
                                {{ $message }}</small>
                        @enderror
                        @error('category_id')
                            <small class="text-danger d-block mt-2"><i class="bi bi-exclamation-circle"></i>
                                {{ $message }}</small>
                        @enderror

                        <!-- Hidden inputs untuk size_id dan category_id -->
                        <input type="hidden" id="hiddenSizeId" name="size_id" value="{{ old('size_id') }}">
                        <input type="hidden" id="hiddenCategoryId" name="category_id" value="{{ old('category_id') }}">
                    </div>

                    <div id="sectionNew" class="d-none fade show">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="custom-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" placeholder="Nama pelanggan..." value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger d-block mt-1"><i class="bi bi-exclamation-circle"></i>
                                        {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="custom-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-select @error('gender') is-invalid @enderror" name="gender">
                                    <option value="">-- Pilih Gender --</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                                @error('gender')
                                    <small class="text-danger d-block mt-1"><i class="bi bi-exclamation-circle"></i>
                                        {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="custom-label">Nomor Telephone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" placeholder="Nomor telephone..." value="{{ old('phone') }}">
                                @error('phone')
                                    <small class="text-danger d-block mt-1"><i class="bi bi-exclamation-circle"></i>
                                        {{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="custom-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Alamat lengkap...">{{ old('address') }}</textarea>
                                @error('address')
                                    <small class="text-danger d-block mt-1"><i class="bi bi-exclamation-circle"></i>
                                        {{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <label class="custom-label d-block mb-2">Kategori Pakaian <span
                                        class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="nameCategory"
                                            value="atasan" id="catAtasan" onchange="toggleMeasurementInputs()"
                                            {{ old('nameCategory') == 'atasan' || old('nameCategory') == '' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="catAtasan">Atasan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="nameCategory"
                                            value="bawahan" id="catBawahan" onchange="toggleMeasurementInputs()"
                                            {{ old('nameCategory') == 'bawahan' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="catBawahan">Bawahan</label>
                                    </div>
                                </div>
                                @error('nameCategory')
                                    <small class="text-danger d-block mt-1"><i class="bi bi-exclamation-circle"></i>
                                        {{ $message }}</small>
                                @enderror
                            </div>

                            <div id="inputAtasan"
                                class="col-12 {{ old('nameCategory') == 'bawahan' ? 'd-none' : '' }}">
                                <div class="measurement-area">
                                    <span class="measurement-badge">Form Ukuran Atasan</span>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="small text-muted fw-bold">Panjang Baju</label>
                                            <input type="number" name="panjang" class="form-control form-control-sm"
                                                value="{{ old('panjang') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="small text-muted fw-bold">Lingkar Badan</label>
                                            <input type="number" name="lingkar_badan"
                                                class="form-control form-control-sm"
                                                value="{{ old('lingkar_badan') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="small text-muted fw-bold">Lingkar Pinggang</label>
                                            <input type="number" name="lingkar_pinggang"
                                                class="form-control form-control-sm"
                                                value="{{ old('lingkar_pinggang') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="small text-muted fw-bold">Lebar Punggung</label>
                                            <input type="number" name="punggung"
                                                class="form-control form-control-sm" value="{{ old('punggung') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="small text-muted fw-bold">Panjang Lengan</label>
                                            <input type="number" name="panjang_lengan"
                                                class="form-control form-control-sm"
                                                value="{{ old('panjang_lengan') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="inputBawahan"
                                class="col-12 {{ old('nameCategory') == 'bawahan' ? '' : 'd-none' }}">
                                <div class="measurement-area">
                                    <span class="measurement-badge">Form Ukuran Bawahan</span>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="small text-muted fw-bold">Panjang (Cln/Rok)</label>
                                            <input type="number" name="panjang_pinggang"
                                                class="form-control form-control-sm"
                                                value="{{ old('panjang_pinggang') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted fw-bold">Lingkar Pinggul</label>
                                            <input type="number" name="pinggul" class="form-control form-control-sm"
                                                value="{{ old('pinggul') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted fw-bold">Pisak (Crotch)</label>
                                            <input type="number" name="pisak" class="form-control form-control-sm"
                                                value="{{ old('pisak') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted fw-bold">Pangkal Paha</label>
                                            <input type="number" name="pangkal_paha"
                                                class="form-control form-control-sm"
                                                value="{{ old('pangkal_paha') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="custom-label">Keterangan / Catatan Jahit</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="3"
                            placeholder="Contoh: Model slimfit, kerah sanghai, kain dari pelanggan...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <small class="text-danger d-block mt-1"><i class="bi bi-exclamation-circle"></i>
                                {{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-link text-decoration-none text-muted"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-simpan shadow"><i class="bi bi-save me-2"></i>Simpan
                        Data</button>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        /**
         * Initialize Select2 when modal is shown
         * This ensures all libraries are loaded
         */
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Form modal script loaded');
            const modalEl = document.getElementById('modalTambahPesanan');
            const formEl = document.getElementById('formAddOrder');

            console.log('Modal element:', modalEl);
            console.log('Form element:', formEl);

            if (modalEl) {
                // Initialize when modal is shown
                modalEl.addEventListener('show.bs.modal', function() {
                    console.log('Modal shown');
                    setTimeout(function() {
                        initializeSelect2();
                        setupEventListeners();
                    }, 100);
                });
            }

            // Add form submission validation
            if (formEl) {
                formEl.addEventListener('submit', function(e) {
                    console.log('Form submit clicked');
                    const isExisting = document.getElementById('typeExisting').checked;
                    const submitBtn = formEl.querySelector('button[type="submit"]');

                    console.log('Is existing customer:', isExisting);

                    // Validate based on customer type
                    if (isExisting) {
                        // For existing customer
                        const customerId = document.getElementById('selectPelanggan').value;
                        const sizeId = document.getElementById('hiddenSizeId').value;
                        const categoryId = document.getElementById('hiddenCategoryId').value;

                        console.log('Customer ID:', customerId);
                        console.log('Size ID:', sizeId);
                        console.log('Category ID:', categoryId);

                        if (!customerId || !sizeId || !categoryId) {
                            e.preventDefault();
                            showValidationError('Silakan pilih pelanggan dan ukuran terlebih dahulu');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="bi bi-save me-2"></i>Simpan Data';
                            console.warn('Validation failed: Missing required fields');
                            return false;
                        }
                    } else {
                        // For new customer - check if required fields are filled
                        const name = formEl.querySelector('input[name="name"]').value;
                        const gender = formEl.querySelector('select[name="gender"]').value;
                        const categoryRadio = formEl.querySelector('input[name="nameCategory"]:checked');
                        const category = categoryRadio ? categoryRadio.value : '';

                        console.log('Name:', name);
                        console.log('Gender:', gender);
                        console.log('Category:', category);

                        if (!name || !gender || !category) {
                            e.preventDefault();
                            showValidationError(
                                'Silakan isi semua field yang diperlukan (nama, gender, kategori)');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="bi bi-save me-2"></i>Simpan Data';
                            console.warn('Validation failed: Missing required new customer fields');
                            return false;
                        }
                    }

                    // Jika validasi berhasil, set loading state dan izinkan form submit
                    console.log('Validation passed, submitting form...');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';
                });
            }
        });

        /**
         * Show validation error message
         */
        function showValidationError(message) {
            const alertEl = document.getElementById('alertError');
            const contentEl = document.getElementById('errorContent');
            contentEl.textContent = message;
            alertEl.classList.remove('d-none');

            // Scroll to alert
            alertEl.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }

        function initializeSelect2() {
            // Check if Select2 is available
            if (typeof jQuery === 'undefined' || typeof jQuery.fn.select2 === 'undefined') {
                console.warn('Select2 is not loaded yet');
                return;
            }

            const element = $('#selectPelanggan');

            // Destroy existing Select2 instance if it exists
            if (element.data('select2')) {
                element.select2('destroy');
            }

            // Initialize Select2
            element.select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: '-- Pilih Pelanggan --',
                allowClear: true,
                dropdownParent: $('#modalTambahPesanan')
            });
        }

        function setupEventListeners() {
            // Load customer sizes when customer is selected
            $('#selectPelanggan').on('change', function() {
                const customerId = $(this).val();
                if (customerId) {
                    loadCustomerSizes(customerId);
                } else {
                    resetSizeDisplay();
                }
            });

            // Toggle between existing and new customer sections
            $('input[name="customerType"]').on('change', function() {
                toggleCustomerType();
            });

            // Toggle between atasan and bawahan measurements
            $('input[name="nameCategory"]').on('change', function() {
                toggleMeasurementInputs();
            });
        }

        /**
         * Load customer sizes via AJAX
         */
        function loadCustomerSizes(customerId) {
            const loadingEl = document.getElementById('loadingSizeExisting');
            const displayEl = document.getElementById('displaySizeExisting');
            const errorEl = document.getElementById('errorSizeExisting');
            const contentEl = document.getElementById('textUkuranExisting');

            // Show loading state
            loadingEl.classList.remove('d-none');
            displayEl.classList.add('d-none');
            errorEl.classList.add('d-none');

            // Fetch data from server
            fetch(`/customers/${customerId}/sizes`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    loadingEl.classList.add('d-none');

                    if (!data.success) {
                        // Show error message
                        showErrorMessage(data.message || 'Gagal mengambil data ukuran');
                        return;
                    }

                    // Display the sizes
                    displaySizes(data.sizes);
                })
                .catch(error => {
                    console.error('Error loading customer sizes:', error);
                    loadingEl.classList.add('d-none');
                    showErrorMessage('Terjadi kesalahan saat mengambil data. Silakan coba lagi.');
                });
        }

        /**
         * Display customer sizes in a formatted manner
         * @param {Array} sizes - Array of size objects
         */
        function displaySizes(sizes) {
            const displayEl = document.getElementById('displaySizeExisting');
            const contentEl = document.getElementById('textUkuranExisting');

            if (!sizes || sizes.length === 0) {
                showErrorMessage('Belum ada data ukuran untuk pelanggan ini');
                return;
            }

            let htmlContent = '';

            sizes.forEach((size, index) => {
                const category = size.category?.nameCategory ?? '-';
                const categoryLabel = category === 'atasan' ? 'Atasan' : 'Bawahan';

                htmlContent +=
                    `<div class="size-item mb-3 p-3 border rounded cursor-pointer" style="cursor: pointer;" onclick="selectSize(${size.id}, ${size.category_id})">`;
                htmlContent += `<div style="display: flex; align-items: center;">`;
                htmlContent +=
                    `<input type="radio" name="sizeSelection" value="${size.id}" data-category-id="${size.category_id}" style="margin-right: 10px;">`;
                htmlContent += `<div>`;
                htmlContent +=
                    `<h6 class="text-primary mb-1"><i class="bi bi-tag me-1"></i>Kategori: ${categoryLabel}</h6>`;
                htmlContent += '<ul class="list-unstyled small mb-0">';

                if (category === 'atasan') {
                    htmlContent += `<li class="mb-1"><strong>Panjang Baju:</strong> ${size.panjang ?? '-'} cm</li>`;
                    htmlContent +=
                        `<li class="mb-1"><strong>Lingkar Badan:</strong> ${size.lingkar_badan ?? '-'} cm</li>`;
                    htmlContent +=
                        `<li class="mb-1"><strong>Lingkar Pinggang:</strong> ${size.lingkar_pinggang ?? '-'} cm</li>`;
                    htmlContent +=
                        `<li class="mb-1"><strong>Lebar Punggung:</strong> ${size.punggung ?? '-'} cm</li>`;
                    htmlContent +=
                        `<li class="mb-1"><strong>Panjang Lengan:</strong> ${size.panjang_lengan ?? '-'} cm</li>`;
                } else if (category === 'bawahan') {
                    htmlContent +=
                        `<li class="mb-1"><strong>Panjang:</strong> ${size.panjang_pinggang ?? '-'} cm</li>`;
                    htmlContent +=
                        `<li class="mb-1"><strong>Lingkar Pinggul:</strong> ${size.pinggul ?? '-'} cm</li>`;
                    htmlContent += `<li class="mb-1"><strong>Pisak (Crotch):</strong> ${size.pisak ?? '-'} cm</li>`;
                    htmlContent +=
                        `<li class="mb-1"><strong>Pangkal Paha:</strong> ${size.pangkal_paha ?? '-'} cm</li>`;
                }

                htmlContent += "</ul>";
                htmlContent += "</div>";
                htmlContent += "</div>";
                htmlContent += "</div>";
            });

            contentEl.innerHTML = htmlContent;
            displayEl.classList.remove('d-none');
        }

        /**
         * Select size and fill hidden inputs
         */
        function selectSize(sizeId, categoryId) {
            document.getElementById('hiddenSizeId').value = sizeId;
            document.getElementById('hiddenCategoryId').value = categoryId;

            // Update radio button visual
            const radios = document.querySelectorAll('input[name="sizeSelection"]');
            radios.forEach(radio => {
                radio.checked = (radio.value == sizeId);
                radio.closest('.size-item').style.backgroundColor = (radio.checked ? '#e7f3ff' : 'transparent');
            });
        }

        /**
         * Show error message
         * @param {string} message - Error message to display
         */
        function showErrorMessage(message) {
            const errorEl = document.getElementById('errorSizeExisting');
            const messageEl = document.getElementById('errorMessage');
            const displayEl = document.getElementById('displaySizeExisting');

            messageEl.textContent = message;
            errorEl.classList.remove('d-none');
            displayEl.classList.add('d-none');
        }

        /**
         * Reset size display when no customer is selected
         */
        function resetSizeDisplay() {
            document.getElementById('displaySizeExisting').classList.add('d-none');
            document.getElementById('errorSizeExisting').classList.add('d-none');
            document.getElementById('loadingSizeExisting').classList.add('d-none');
        }

        /**
         * Toggle between existing and new customer sections
         */
        function toggleCustomerType() {
            const isExisting = document.getElementById('typeExisting').checked;
            const secExisting = document.getElementById('sectionExisting');
            const secNew = document.getElementById('sectionNew');

            if (isExisting) {
                secExisting.classList.remove('d-none');
                secNew.classList.add('d-none');
                resetSizeDisplay();
            } else {
                secExisting.classList.add('d-none');
                secNew.classList.remove('d-none');
            }
        }

        /**
         * Toggle between atasan and bawahan measurement inputs
         */
        function toggleMeasurementInputs() {
            const isAtasan = document.getElementById('catAtasan').checked;
            const divAtasan = document.getElementById('inputAtasan');
            const divBawahan = document.getElementById('inputBawahan');

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
