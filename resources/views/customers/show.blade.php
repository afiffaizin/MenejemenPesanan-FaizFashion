@extends('layouts.app')

@section('title', 'Detail Customer')

@section('content')
    <div class="p-4 md:p-6 lg:p-8 flex flex-col items-center min-h-[80vh] gap-6" x-data="sizeManager()">

        {{-- Header Back Button --}}
        <div class="w-full max-w-4xl flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">Detail Customer</h2>
            <a href="{{ route('customers.index') }}"
               class="px-4 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        {{-- 1. Profile Card --}}
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-6 md:p-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                
                {{-- Avatar --}}
                @php
                    $initials = collect(explode(' ', $customer->name))->map(fn($n) => substr($n, 0, 1))->take(2)->implode('');
                @endphp
                <div class="w-24 h-24 rounded-full bg-blue-600 text-white flex items-center justify-center text-3xl font-bold flex-shrink-0 shadow-md">
                    {{ strtoupper($initials) }}
                </div>

                {{-- Info --}}
                <div class="flex-1 space-y-3">
                    <div class="flex items-center gap-3">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $customer->name }}</h3>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span> Active
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-telephone text-gray-400 text-base"></i>
                            <span>{{ $customer->phone ?? 'Belum ada nomor telepon' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-gender-ambiguous text-gray-400 text-base"></i>
                            <span>{{ $customer->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        <div class="flex items-start gap-2 md:col-span-2">
                            <i class="bi bi-geo-alt text-gray-400 text-base mt-0.5"></i>
                            <span>{{ $customer->address ?? 'Belum ada alamat' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-400 text-xs mt-2 md:col-span-2">
                            <i class="bi bi-calendar3"></i>
                            <span>Registered: {{ $customer->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Edit Button --}}
                <div class="flex-shrink-0 mt-4 md:mt-0 w-full md:w-auto">
                    <a href="{{ route('customers.edit', $customer->id) }}"
                       class="w-full md:w-auto flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-semibold text-blue-600 bg-white border-2 border-blue-600 rounded-lg shadow-sm hover:bg-blue-50 transition-colors">
                        <i class="bi bi-pencil"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>

        {{-- 2. Sizes Sections --}}
        <div class="w-full max-w-4xl space-y-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="bi bi-rulers"></i> Data Ukuran
            </h3>

            @forelse($customer->sizes as $size)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden relative">
                    {{-- Size Header --}}
                    <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between bg-gray-50/50">
                        <h4 class="text-base font-bold text-slate-800 flex items-center gap-2">
                            <i class="bi bi-file-ruled text-blue-600"></i> Ukuran: {{ ucfirst($size->category->nameCategory ?? 'Tidak diketahui') }}
                        </h4>
                        <div class="flex items-center gap-2">
                            <button @click='openEditModal(@json($size))'
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-50 transition-colors"
                                    title="Edit Ukuran">
                                <i class="bi bi-pencil-square text-lg"></i>
                            </button>
                            <form action="{{ route('sizes.destroy', $size->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ukuran ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-red-500 hover:bg-red-50 transition-colors" title="Hapus Ukuran">
                                    <i class="bi bi-trash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Size Grid --}}
                    <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                        @if(($size->category->nameCategory ?? '') === 'atasan' || ($size->category->nameCategory ?? '') === 'Atasan')
                            <x-size-card label="Panjang Baju" :value="$size->panjang" />
                            <x-size-card label="Lingkar Badan" :value="$size->lingkar_badan" />
                            <x-size-card label="Lingkar Pinggang" :value="$size->lingkar_pinggang" />
                            <x-size-card label="Lebar Punggung" :value="$size->punggung" />
                            <x-size-card label="Panjang Lengan" :value="$size->panjang_lengan" />
                        @else
                            <x-size-card label="Panjang (Cln/Rok)" :value="$size->panjang_pinggang" />
                            <x-size-card label="Lingkar Pinggul" :value="$size->pinggul" />
                            <x-size-card label="Pisak" :value="$size->pisak" />
                            <x-size-card label="Pangkal Paha" :value="$size->pangkal_paha" />
                        @endif

                        @if($size->keterangan)
                            <div class="col-span-2 md:col-span-4 bg-yellow-50 rounded-xl p-4 border border-yellow-100 mt-2">
                                <p class="text-xs text-yellow-600 font-semibold mb-1">Catatan Tambahan:</p>
                                <p class="text-sm font-medium text-yellow-900">{{ $size->keterangan }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="px-6 py-3 bg-gray-50/30 text-right text-xs text-gray-400 border-t border-gray-50">
                        Last updated: {{ $size->updated_at->format('d M Y, H:i') }}
                    </div>
                </div>
            @empty
                <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-8 text-center">
                    <div class="inline-flex w-12 h-12 rounded-full bg-gray-100 text-gray-400 items-center justify-center text-xl mb-3">
                        <i class="bi bi-rulers"></i>
                    </div>
                    <h4 class="text-gray-900 font-medium mb-1">Belum ada ukuran</h4>
                    <p class="text-sm text-gray-500 mb-4">Pelanggan ini belum memiliki data ukuran.</p>
                </div>
            @endforelse

            {{-- Add Size Button (Redesigned) --}}
            <button @click="openAddModal()"
                    class="w-full relative flex flex-col items-center justify-center gap-3 bg-gray-50/50 hover:bg-blue-50/50 border-2 border-dashed border-gray-300 hover:border-blue-400 rounded-2xl p-8 transition-all duration-200 group cursor-pointer overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-white/60 pointer-events-none"></div>
                
                {{-- Icon Circle --}}
                <div class="relative w-14 h-14 flex items-center justify-center bg-white rounded-full shadow-sm text-gray-400 group-hover:text-blue-600 group-hover:scale-110 group-hover:shadow-md transition-all duration-300 z-10 border border-gray-100 group-hover:border-blue-100">
                    <i class="bi bi-plus text-3xl font-bold"></i>
                </div>
                
                {{-- Text Content --}}
                <div class="relative z-10">
                    <p class="text-gray-700 group-hover:text-blue-700 font-bold text-base transition-colors">Tambah Ukuran Baru</p>
                    <p class="text-gray-400 group-hover:text-blue-500/70 text-xs mt-1 transition-colors">Klik untuk menambahkan data ukuran (Atasan / Bawahan)</p>
                </div>
            </button>
        </div>

        {{-- Add Size Modal --}}
        <div x-show="showAddModal" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-black/50 modal-backdrop-blur" @click="showAddModal = false"></div>
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl animate-fade-in" @click.stop>
                    <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white px-6 py-5 rounded-t-2xl flex justify-between items-center">
                        <h2 class="text-base font-bold flex items-center gap-2"><i class="bi bi-plus-circle"></i> Tambah Ukuran</h2>
                        <button @click="showAddModal = false" class="text-white hover:text-gray-200"><i class="bi bi-x-lg"></i></button>
                    </div>
                    <form action="{{ route('sizes.store', $customer->id) }}" method="POST">
                        @csrf
                        <div class="p-6">
                            {{-- Category Select --}}
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-gray-600 mb-3">Kategori Pakaian <span class="text-red-500">*</span></label>
                                <div class="flex gap-3">
                                    <label class="cursor-pointer flex-1">
                                        <input type="radio" name="nameCategory" value="Atasan" x-model="addCategory" class="hidden peer">
                                        <div class="peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 border-2 border-gray-200 rounded-xl p-3 text-center transition-all duration-200 hover:border-blue-300">
                                            <p class="text-sm font-semibold text-gray-700">Atasan</p>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer flex-1">
                                        <input type="radio" name="nameCategory" value="Bawahan" x-model="addCategory" class="hidden peer">
                                        <div class="peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 border-2 border-gray-200 rounded-xl p-3 text-center transition-all duration-200 hover:border-blue-300">
                                            <p class="text-sm font-semibold text-gray-700">Bawahan</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            {{-- Measurement: Atasan --}}
                            <div x-show="addCategory === 'Atasan'" class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Panjang Baju</label><input type="number" step="0.1" name="panjang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Lingkar Badan</label><input type="number" step="0.1" name="lingkar_badan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">L. Pinggang</label><input type="number" step="0.1" name="lingkar_pinggang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Lebar Punggung</label><input type="number" step="0.1" name="punggung" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Panjang Lengan</label><input type="number" step="0.1" name="panjang_lengan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                            </div>
                            
                            {{-- Measurement: Bawahan --}}
                            <div x-show="addCategory === 'Bawahan'" class="grid grid-cols-2 gap-3" style="display: none;">
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Panjang (Cln/Rok)</label><input type="number" step="0.1" name="panjang_pinggang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Lingkar Pinggul</label><input type="number" step="0.1" name="pinggul" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Pisak</label><input type="number" step="0.1" name="pisak" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Pangkal Paha</label><input type="number" step="0.1" name="pangkal_paha" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Catatan / Keterangan</label>
                                <textarea name="keterangan" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 rounded-b-2xl flex justify-end gap-2">
                            <button type="button" @click="showAddModal = false" class="px-4 py-2 text-sm font-medium text-gray-600">Batal</button>
                            <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit Size Modal --}}
        <div x-show="showEditModal" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-black/50 modal-backdrop-blur" @click="showEditModal = false"></div>
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl animate-fade-in" @click.stop>
                    <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white px-6 py-5 rounded-t-2xl flex justify-between items-center">
                        <h2 class="text-base font-bold flex items-center gap-2"><i class="bi bi-pencil-square"></i> Edit Ukuran</h2>
                        <button @click="showEditModal = false" class="text-white hover:text-gray-200"><i class="bi bi-x-lg"></i></button>
                    </div>
                    <form :action="editFormAction" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="p-6">
                            {{-- Category (Readonly in edit) --}}
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Kategori</label>
                                <input type="text" x-model="editData.categoryName" readonly class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-500 cursor-not-allowed">
                            </div>
                            
                            {{-- Measurement: Atasan --}}
                            <div x-show="editData.categoryName.toLowerCase() === 'atasan'" class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Panjang Baju</label><input type="number" step="0.1" name="panjang" x-model="editData.panjang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Lingkar Badan</label><input type="number" step="0.1" name="lingkar_badan" x-model="editData.lingkar_badan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">L. Pinggang</label><input type="number" step="0.1" name="lingkar_pinggang" x-model="editData.lingkar_pinggang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Lebar Punggung</label><input type="number" step="0.1" name="punggung" x-model="editData.punggung" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Panjang Lengan</label><input type="number" step="0.1" name="panjang_lengan" x-model="editData.panjang_lengan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                            </div>
                            
                            {{-- Measurement: Bawahan --}}
                            <div x-show="editData.categoryName.toLowerCase() !== 'atasan'" class="grid grid-cols-2 gap-3" style="display: none;">
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Panjang (Cln/Rok)</label><input type="number" step="0.1" name="panjang_pinggang" x-model="editData.panjang_pinggang" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Lingkar Pinggul</label><input type="number" step="0.1" name="pinggul" x-model="editData.pinggul" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Pisak</label><input type="number" step="0.1" name="pisak" x-model="editData.pisak" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Pangkal Paha</label><input type="number" step="0.1" name="pangkal_paha" x-model="editData.pangkal_paha" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></div>
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Catatan / Keterangan</label>
                                <textarea name="keterangan" rows="2" x-model="editData.keterangan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 rounded-b-2xl flex justify-end gap-2">
                            <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm font-medium text-gray-600">Batal</button>
                            <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function sizeManager() {
            return {
                showAddModal: false,
                showEditModal: false,
                addCategory: 'Atasan',
                editFormAction: '',
                editData: {
                    id: '',
                    categoryName: 'Atasan',
                    panjang: '', lingkar_badan: '', lingkar_pinggang: '', punggung: '', panjang_lengan: '',
                    panjang_pinggang: '', pinggul: '', pisak: '', pangkal_paha: '', keterangan: ''
                },

                openAddModal() {
                    this.addCategory = 'Atasan';
                    this.showAddModal = true;
                },

                openEditModal(size) {
                    this.editData = {
                        ...size,
                        categoryName: size.category ? size.category.nameCategory : 'Atasan'
                    };
                    this.editFormAction = `/sizes/${size.id}`;
                    this.showEditModal = true;
                }
            }
        }
    </script>
    @endpush
@endsection
