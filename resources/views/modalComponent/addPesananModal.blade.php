{{-- Add Pesanan Modal (Tailwind + Alpine.js) --}}
<div id="modalTambahPesanan" class="hidden fixed inset-0 z-[60] overflow-y-auto" x-data="orderModal()" x-init="init()">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/50 modal-backdrop-blur" @click="closeModal()"></div>

    {{-- Modal Content --}}
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl animate-fade-in">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white px-6 py-5 rounded-t-2xl flex items-center justify-between">
                <h2 class="text-base font-bold flex items-center gap-2">
                    <i class="bi bi-bag-plus"></i> Tambah Pesanan
                </h2>
                <button @click="closeModal()" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors">
                    <i class="bi bi-x-lg text-sm"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('orders.store') }}" id="formAddOrder" @submit="onSubmit($event)">
                @csrf

                {{-- Validation Error --}}
                <div x-show="errorMsg" x-cloak class="mx-6 mt-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700 flex items-center gap-2">
                    <i class="bi bi-exclamation-circle"></i>
                    <span x-text="errorMsg"></span>
                </div>

                <div class="p-6">

                    {{-- Toggle: Pelanggan Lama / Baru --}}
                    <div class="flex justify-center mb-6">
                        <div class="inline-flex bg-gray-100 rounded-full p-1 shadow-inner">
                            <label class="cursor-pointer">
                                <input type="radio" name="customerType" value="existing" x-model="customerType" class="hidden peer">
                                <span class="block px-6 py-2.5 text-sm font-semibold rounded-full transition-all duration-300 peer-checked:bg-white peer-checked:text-gray-900 peer-checked:shadow text-gray-500">
                                    Pelanggan Lama
                                </span>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="customerType" value="new" x-model="customerType" class="hidden peer">
                                <span class="block px-6 py-2.5 text-sm font-semibold rounded-full transition-all duration-300 peer-checked:bg-white peer-checked:text-gray-900 peer-checked:shadow text-gray-500">
                                    Pelanggan Baru
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Section: Existing Customer --}}
                    <div x-show="customerType === 'existing'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1.5">Cari Nama Pelanggan <span class="text-red-500">*</span></label>
                            <select id="selectPelanggan" name="customer_id" x-model="customerId" @change="loadSizes()"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Loading --}}
                        <div x-show="loadingSizes" class="text-center py-4">
                            <svg class="animate-spin h-5 w-5 text-blue-500 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm text-gray-500">Memuat data ukuran...</span>
                        </div>

                        {{-- Sizes Display --}}
                        <div x-show="sizes.length > 0 && !loadingSizes" class="mt-3 bg-blue-50 rounded-xl p-4">
                            <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                <i class="bi bi-ruler"></i> Pilih Ukuran <span class="text-red-500">*</span>
                            </h3>
                            <div class="space-y-2">
                                <template x-for="(size, idx) in sizes" :key="size.id">
                                    <div @click="selectSize(size)"
                                         :class="selectedSizeId == size.id ? 'border-blue-500 bg-blue-50 ring-2 ring-blue-200' : 'border-gray-200 bg-white hover:border-blue-300'"
                                         class="p-3 border-2 rounded-xl cursor-pointer transition-all duration-200">
                                        <div class="flex items-center gap-3">
                                            <div :class="selectedSizeId == size.id ? 'bg-blue-500 border-blue-500' : 'border-gray-300 bg-white'"
                                                 class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-colors">
                                                <div x-show="selectedSizeId == size.id" class="w-2 h-2 bg-white rounded-full"></div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-blue-700">
                                                    <i class="bi bi-tag mr-1"></i>
                                                    Kategori: <span x-text="size.category?.nameCategory === 'atasan' ? 'Atasan' : 'Bawahan'"></span>
                                                </p>
                                                <div class="mt-1 text-xs text-gray-600 space-y-0.5">
                                                    <template x-if="size.category?.nameCategory === 'atasan'">
                                                        <div>
                                                            <span>Panjang: <strong x-text="(size.panjang ?? '-') + ' cm'"></strong></span> ·
                                                            <span>L.Badan: <strong x-text="(size.lingkar_badan ?? '-') + ' cm'"></strong></span> ·
                                                            <span>L.Pinggang: <strong x-text="(size.lingkar_pinggang ?? '-') + ' cm'"></strong></span>
                                                        </div>
                                                    </template>
                                                    <template x-if="size.category?.nameCategory !== 'atasan'">
                                                        <div>
                                                            <span>Panjang: <strong x-text="(size.panjang_pinggang ?? '-') + ' cm'"></strong></span> ·
                                                            <span>Pinggul: <strong x-text="(size.pinggul ?? '-') + ' cm'"></strong></span> ·
                                                            <span>Pisak: <strong x-text="(size.pisak ?? '-') + ' cm'"></strong></span>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Error --}}
                        <div x-show="sizeError && !loadingSizes" class="mt-3 p-3 bg-blue-50 rounded-lg text-sm text-blue-700 flex items-center gap-2">
                            <i class="bi bi-info-circle"></i>
                            <span x-text="sizeError"></span>
                        </div>

                        <input type="hidden" name="size_id" :value="selectedSizeId">
                        <input type="hidden" name="category_id" :value="selectedCategoryId">
                    </div>

                    {{-- Section: New Customer --}}
                    <div x-show="customerType === 'new'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       placeholder="Nama pelanggan..." value="{{ old('name') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1.5">Gender <span class="text-red-500">*</span></label>
                                <select name="gender" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">-- Pilih Gender --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1.5">Nomor Telephone</label>
                                <input type="text" name="phone" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       placeholder="Nomor telephone..." value="{{ old('phone') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1.5">Alamat</label>
                                <textarea name="address" rows="1" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                          placeholder="Alamat lengkap...">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        {{-- Category Toggle --}}
                        <div class="mt-5">
                            <label class="block text-sm font-semibold text-gray-600 mb-3">Kategori Pakaian <span class="text-red-500">*</span></label>
                            <div class="flex gap-3">
                                <label class="cursor-pointer flex-1">
                                    <input type="radio" name="nameCategory" value="atasan" x-model="newCategory" class="hidden peer">
                                    <div class="peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 border-2 border-gray-200 rounded-xl p-3 text-center transition-all duration-200 hover:border-blue-300">
                                        <i class="bi bi-chevron-up text-lg text-blue-500"></i>
                                        <p class="text-sm font-semibold text-gray-700 mt-1">Atasan</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer flex-1">
                                    <input type="radio" name="nameCategory" value="bawahan" x-model="newCategory" class="hidden peer">
                                    <div class="peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 border-2 border-gray-200 rounded-xl p-3 text-center transition-all duration-200 hover:border-blue-300">
                                        <i class="bi bi-chevron-down text-lg text-blue-500"></i>
                                        <p class="text-sm font-semibold text-gray-700 mt-1">Bawahan</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Measurement: Atasan --}}
                        <div x-show="newCategory === 'atasan'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-5">
                            <div class="measurement-dashed rounded-xl p-5 bg-white">
                                <span class="measurement-badge inline-block bg-slate-800 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                    Form Ukuran Atasan
                                </span>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Panjang Baju</label>
                                        <input type="number" name="panjang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" value="{{ old('panjang') }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Lingkar Badan</label>
                                        <input type="number" name="lingkar_badan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" value="{{ old('lingkar_badan') }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Lingkar Pinggang</label>
                                        <input type="number" name="lingkar_pinggang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" value="{{ old('lingkar_pinggang') }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Lebar Punggung</label>
                                        <input type="number" name="punggung" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" value="{{ old('punggung') }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Panjang Lengan</label>
                                        <input type="number" name="panjang_lengan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" value="{{ old('panjang_lengan') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Measurement: Bawahan --}}
                        <div x-show="newCategory === 'bawahan'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-5">
                            <div class="measurement-dashed rounded-xl p-5 bg-white">
                                <span class="measurement-badge inline-block bg-slate-800 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                    Form Ukuran Bawahan
                                </span>
                                <div class="grid grid-cols-2 gap-3 mt-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Panjang (Cln/Rok)</label>
                                        <input type="number" name="panjang_pinggang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" value="{{ old('panjang_pinggang') }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Lingkar Pinggul</label>
                                        <input type="number" name="pinggul" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" value="{{ old('pinggul') }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Pisak (Crotch)</label>
                                        <input type="number" name="pisak" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" value="{{ old('pisak') }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Pangkal Paha</label>
                                        <input type="number" name="pangkal_paha" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" value="{{ old('pangkal_paha') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div class="mt-5">
                        <label class="block text-sm font-semibold text-gray-600 mb-1.5">Keterangan / Catatan Jahit</label>
                        <textarea name="keterangan" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                  placeholder="Contoh: Model slimfit, kerah sanghai, kain dari pelanggan...">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-2 px-6 py-4 bg-gray-50 rounded-b-2xl">
                    <button type="button" @click="closeModal()" class="px-4 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                        Batal
                    </button>
                    <button type="submit" :disabled="submitting"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        <template x-if="!submitting"><span><i class="bi bi-save mr-1"></i> Simpan Data</span></template>
                        <template x-if="submitting">
                            <span class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Menyimpan...
                            </span>
                        </template>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function orderModal() {
    return {
        customerType: 'existing',
        customerId: '',
        sizes: [],
        selectedSizeId: '',
        selectedCategoryId: '',
        loadingSizes: false,
        sizeError: '',
        errorMsg: '',
        submitting: false,
        newCategory: 'atasan',

        init() {},

        closeModal() {
            document.getElementById('modalTambahPesanan').classList.add('hidden');
            this.resetForm();
        },

        resetForm() {
            this.sizes = [];
            this.selectedSizeId = '';
            this.selectedCategoryId = '';
            this.sizeError = '';
            this.errorMsg = '';
            this.loadingSizes = false;
        },

        async loadSizes() {
            if (!this.customerId) {
                this.resetForm();
                return;
            }
            this.loadingSizes = true;
            this.sizeError = '';
            this.sizes = [];
            this.selectedSizeId = '';
            this.selectedCategoryId = '';

            try {
                const res = await fetch(`/customers/${this.customerId}/sizes`);
                const data = await res.json();

                this.loadingSizes = false;

                if (!data.success) {
                    this.sizeError = data.message || 'Gagal mengambil data ukuran';
                    return;
                }
                if (!data.sizes || data.sizes.length === 0) {
                    this.sizeError = 'Belum ada data ukuran untuk pelanggan ini';
                    return;
                }
                this.sizes = data.sizes;
            } catch (e) {
                this.loadingSizes = false;
                this.sizeError = 'Terjadi kesalahan saat mengambil data.';
            }
        },

        selectSize(size) {
            this.selectedSizeId = size.id;
            this.selectedCategoryId = size.category_id;
        },

        onSubmit(e) {
            if (this.customerType === 'existing') {
                if (!this.customerId || !this.selectedSizeId || !this.selectedCategoryId) {
                    e.preventDefault();
                    this.errorMsg = 'Silakan pilih pelanggan dan ukuran terlebih dahulu';
                    return;
                }
            } else {
                const form = e.target;
                const name = form.querySelector('input[name="name"]')?.value;
                const gender = form.querySelector('select[name="gender"]')?.value;
                if (!name || !gender || !this.newCategory) {
                    e.preventDefault();
                    this.errorMsg = 'Silakan isi semua field yang diperlukan (nama, gender, kategori)';
                    return;
                }
            }
            this.submitting = true;
            this.errorMsg = '';
        }
    };
}
</script>
@endpush
