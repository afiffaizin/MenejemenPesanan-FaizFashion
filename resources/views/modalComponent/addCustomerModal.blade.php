{{-- Add Customer Modal (Tailwind + Alpine.js) --}}
<div id="modalTambahCustomer" class="hidden fixed inset-0 z-[60] overflow-y-auto" x-data="customerModal()">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/50 modal-backdrop-blur" @click="closeModal()"></div>

    {{-- Modal Content --}}
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl animate-fade-in">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white px-6 py-5 rounded-t-2xl flex items-center justify-between">
                <h2 class="text-base font-bold flex items-center gap-2">
                    <i class="bi bi-person-plus"></i> Tambah Customer Baru
                </h2>
                <button @click="closeModal()" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors">
                    <i class="bi bi-x-lg text-sm"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('customers.store') }}">
                @csrf
                <input type="hidden" name="customerType" value="new">

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Nama Customer...">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1.5">Gender <span class="text-red-500">*</span></label>
                            <select name="gender"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1.5">Nomor Telephone</label>
                            <input type="text" name="phone"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Nomor telephone...">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1.5">Alamat</label>
                            <textarea name="address" rows="1"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                      placeholder="Alamat lengkap..."></textarea>
                        </div>
                    </div>

                    {{-- Category Toggle --}}
                    <div class="mt-5">
                        <label class="block text-sm font-semibold text-gray-600 mb-3">Kategori Ukuran Awal <span class="text-red-500">*</span></label>
                        <div class="flex gap-3">
                            <label class="cursor-pointer flex-1">
                                <input type="radio" name="nameCategory" value="Atasan" x-model="category" class="hidden peer" checked>
                                <div class="peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 border-2 border-gray-200 rounded-xl p-3 text-center transition-all duration-200 hover:border-blue-300">
                                    <i class="bi bi-chevron-up text-lg text-blue-500"></i>
                                    <p class="text-sm font-semibold text-gray-700 mt-1">Atasan</p>
                                </div>
                            </label>
                            <label class="cursor-pointer flex-1">
                                <input type="radio" name="nameCategory" value="Bawahan" x-model="category" class="hidden peer">
                                <div class="peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 border-2 border-gray-200 rounded-xl p-3 text-center transition-all duration-200 hover:border-blue-300">
                                    <i class="bi bi-chevron-down text-lg text-blue-500"></i>
                                    <p class="text-sm font-semibold text-gray-700 mt-1">Bawahan</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Measurement: Atasan --}}
                    <div x-show="category === 'Atasan'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-5">
                        <div class="measurement-dashed rounded-xl p-5 bg-white">
                            <span class="measurement-badge inline-block bg-slate-800 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                Form Ukuran Atasan
                            </span>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Panjang Baju</label>
                                    <input type="number" name="panjang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Lingkar Badan</label>
                                    <input type="number" name="lingkar_badan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Lingkar Pinggang</label>
                                    <input type="number" name="lingkar_pinggang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Lebar Punggung</label>
                                    <input type="number" name="punggung" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Panjang Lengan</label>
                                    <input type="number" name="panjang_lengan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Measurement: Bawahan --}}
                    <div x-show="category === 'Bawahan'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-5">
                        <div class="measurement-dashed rounded-xl p-5 bg-white">
                            <span class="measurement-badge inline-block bg-slate-800 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                Form Ukuran Bawahan
                            </span>
                            <div class="grid grid-cols-2 gap-3 mt-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Panjang (Cln/Rok)</label>
                                    <input type="number" name="panjang_pinggang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Lingkar Pinggul</label>
                                    <input type="number" name="pinggul" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Pisak (Crotch)</label>
                                    <input type="number" name="pisak" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Pangkal Paha</label>
                                    <input type="number" name="pangkal_paha" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-2 px-6 py-4 bg-gray-50 rounded-b-2xl">
                    <button type="button" @click="closeModal()" class="px-4 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
                        <i class="bi bi-save"></i> Simpan Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function customerModal() {
    return {
        category: 'Atasan',

        closeModal() {
            document.getElementById('modalTambahCustomer').classList.add('hidden');
        }
    };
}
</script>
@endpush
