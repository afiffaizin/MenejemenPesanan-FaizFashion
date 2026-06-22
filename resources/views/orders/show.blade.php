@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="p-4 md:p-6 lg:p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="javascript:history.back()" class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm">
                <i class="bi bi-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                    Detail Pesanan
                    <span class="text-sm font-medium px-3 py-1 rounded-full {{ strtolower($order->status) == 'selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $order->status == 'Pending' ? 'Menunggu' : $order->status }}
                    </span>
                </h1>
                <p class="text-sm text-gray-500 mt-1">#{{ $order->order_number ?? 'ORD-' . $order->id }}</p>
            </div>
        </div>
        
        {{-- Optional action buttons like Print can go here --}}
        <button onclick="window.print()" class="hidden md:inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
            <i class="bi bi-printer"></i>
            Cetak Struk
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Info Customer & Tanggal --}}
        <div class="flex flex-col gap-6">
            
            {{-- Info Customer --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Informasi Pelanggan</h3>
                <div class="flex items-center gap-4 mb-5">
                    @php
                        $name = $order->customer->name ?? 'Unknown';
                        $initials = collect(explode(' ', $name))->map(fn($n) => substr($n, 0, 1))->take(2)->implode('');
                    @endphp
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold border border-blue-100 flex-shrink-0">
                        {{ strtoupper($initials) }}
                    </div>
                    <div>
                        <h4 class="text-gray-900 font-bold text-lg">{{ $name }}</h4>
                        <p class="text-gray-500 text-sm">{{ $order->customer->phone ?? 'Tidak ada nomor telepon' }}</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex flex-col gap-1">
                        <span class="text-xs text-gray-400 font-medium">Alamat</span>
                        <span class="text-sm text-gray-700">{{ $order->customer->address ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-xs text-gray-400 font-medium">Gender</span>
                        <span class="text-sm text-gray-700">
                            @if(($order->customer->gender ?? '') == 'L')
                                <i class="bi bi-gender-male text-blue-500 mr-1"></i> Laki-laki
                            @elseif(($order->customer->gender ?? '') == 'P')
                                <i class="bi bi-gender-female text-pink-500 mr-1"></i> Perempuan
                            @else
                                -
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Info Waktu --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Waktu Transaksi</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Diterima pada</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $order->created_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                    @if(strtolower($order->status) == 'selesai')
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Selesai pada</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $order->updated_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
        </div>

        {{-- Kolom Kanan: Detail Ukuran --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Spesifikasi Ukuran</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Detail ukuran yang digunakan untuk pesanan ini.</p>
                    </div>
                    @php
                        $catName = strtolower($order->size->category->nameCategory ?? '');
                        $badgeColor = $catName == 'atasan' ? 'bg-purple-100 text-purple-700' : ($catName == 'bawahan' ? 'bg-teal-100 text-teal-700' : 'bg-gray-100 text-gray-700');
                    @endphp
                    <span class="px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider {{ $badgeColor }}">
                        {{ $order->size->category->nameCategory ?? 'Tidak Diketahui' }}
                    </span>
                </div>

                <div class="p-6 bg-gray-50/50">
                    @if($order->size)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @if($catName === 'atasan')
                                <x-size-card label="Panjang Baju" :value="$order->size->panjang" />
                                <x-size-card label="Lingkar Badan" :value="$order->size->lingkar_badan" />
                                <x-size-card label="Lingkar Pinggang" :value="$order->size->lingkar_pinggang" />
                                <x-size-card label="Lebar Punggung" :value="$order->size->punggung" />
                                <x-size-card label="Panjang Lengan" :value="$order->size->panjang_lengan" />
                            @else
                                <x-size-card label="Panjang (Cln/Rok)" :value="$order->size->panjang_pinggang" />
                                <x-size-card label="Lingkar Pinggul" :value="$order->size->pinggul" />
                                <x-size-card label="Pisak" :value="$order->size->pisak" />
                                <x-size-card label="Pangkal Paha" :value="$order->size->pangkal_paha" />
                            @endif
                        </div>

                        @if($order->size->keterangan)
                            <div class="mt-6 bg-yellow-50 rounded-xl p-4 border border-yellow-100">
                                <div class="flex items-center gap-2 text-yellow-600 font-semibold mb-2">
                                    <i class="bi bi-pencil-square"></i>
                                    <span class="text-sm">Catatan Pesanan:</span>
                                </div>
                                <p class="text-sm font-medium text-yellow-900 leading-relaxed">{{ $order->size->keterangan }}</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-10">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                <i class="bi bi-rulers text-2xl"></i>
                            </div>
                            <h4 class="text-gray-900 font-medium">Data Ukuran Tidak Ditemukan</h4>
                            <p class="text-sm text-gray-500 mt-1">Pesanan ini mungkin dibuat sebelum sistem multi-ukuran diterapkan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .p-4, .p-4 * { visibility: visible; }
        .p-4 { position: absolute; left: 0; top: 0; width: 100%; }
        button, a, .shadow-sm { display: none !important; box-shadow: none !important; }
        .bg-white { background: transparent !important; }
    }
</style>
@endsection
