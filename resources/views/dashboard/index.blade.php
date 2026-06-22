@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="p-4 md:p-6 lg:p-8">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Overview Bisnis 👋</h1>
                <p class="text-sm text-gray-500 mt-1">Pantau performa penjahit dan manajemen antrean Anda hari ini.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="document.getElementById('modalTambahCustomer').classList.remove('hidden')"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 hover:border-gray-300 transition-all">
                    <i class="bi bi-person-plus text-lg"></i>
                    Customer Baru
                </button>
                <button onclick="document.getElementById('modalTambahPesanan').classList.remove('hidden')"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl shadow-sm hover:bg-blue-700 hover:shadow-md transition-all">
                    <i class="bi bi-plus-lg"></i>
                    Buat Pesanan
                </button>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Antrian Jahit --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-5 stat-card-hover group">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl group-hover:bg-blue-100 transition-colors flex-shrink-0">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-gray-900 leading-none">{{ $pendingOrders }}</div>
                    <div class="text-sm text-gray-500 font-medium mt-1">Antrian Jahit</div>
                </div>
            </div>

            {{-- Pesanan Selesai --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-5 stat-card-hover group">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl group-hover:bg-emerald-100 transition-colors flex-shrink-0">
                    <i class="bi bi-check-all"></i>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-gray-900 leading-none">{{ $orderanSelesai }}</div>
                    <div class="text-sm text-gray-500 font-medium mt-1">Pesanan Selesai</div>
                </div>
            </div>

            {{-- Total Orderan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-5 stat-card-hover group">
                <div class="w-14 h-14 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center text-2xl group-hover:bg-violet-100 transition-colors flex-shrink-0">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-gray-900 leading-none">{{ $totalOrderan }}</div>
                    <div class="text-sm text-gray-500 font-medium mt-1">Total Orderan</div>
                </div>
            </div>

            {{-- Total Customers --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-5 stat-card-hover group">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl group-hover:bg-amber-100 transition-colors flex-shrink-0">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-gray-900 leading-none">{{ $totalCustomers }}</div>
                    <div class="text-sm text-gray-500 font-medium mt-1">Total Pelanggan</div>
                </div>
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- Line Chart — Monthly Trend --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Tren Pesanan Bulanan</h2>
                        <p class="text-xs text-gray-500 mt-1">Statistik pesanan selama 12 bulan terakhir</p>
                    </div>
                    <div class="p-2 bg-gray-50 rounded-lg border border-gray-100 text-gray-400">
                        <i class="bi bi-graph-up text-lg"></i>
                    </div>
                </div>
                <div class="chart-container relative" style="height: 300px; width: 100%;">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

            {{-- Doughnut Chart — Status --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Rasio Status</h2>
                        <p class="text-xs text-gray-500 mt-1">Distribusi pesanan saat ini</p>
                    </div>
                    <div class="p-2 bg-gray-50 rounded-lg border border-gray-100 text-gray-400">
                        <i class="bi bi-pie-chart text-lg"></i>
                    </div>
                </div>
                <div class="chart-container flex items-center justify-center relative" style="height: 300px; width: 100%;">
                    <canvas id="doughnutChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Recent Orders Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Pesanan Masuk Terbaru (Antrian)</h2>
                    <p class="text-xs text-gray-500 mt-1">Daftar pesanan pending yang perlu segera diproses.</p>
                </div>
                <a href="{{ route('orders.getOrders') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Order ID</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Pelanggan</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Tanggal Masuk</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Item</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100/80">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-900">{{ $order->order_number ?? 'ORD-' . $order->id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $name = $order->customer->name ?? 'Unknown';
                                            $initials = collect(explode(' ', $name))->map(fn($n) => substr($n, 0, 1))->take(2)->implode('');
                                        @endphp
                                        <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold border border-blue-100 flex-shrink-0">
                                            {{ strtoupper($initials) }}
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $catName = strtolower($order->size->category->nameCategory ?? '');
                                        $badgeColor = $catName == 'atasan' ? 'bg-purple-50 text-purple-700 border border-purple-100' : ($catName == 'bawahan' ? 'bg-teal-50 text-teal-700 border border-teal-100' : 'bg-gray-50 text-gray-600 border border-gray-200');
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $badgeColor }}">
                                        {{ ucfirst($catName ?: 'Unknown') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200" title="Detail Pesanan">
                                        <i class="bi bi-eye text-sm"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="bi bi-check2-circle text-4xl text-gray-300 mb-2"></i>
                                        <p>Hebat! Tidak ada antrian pesanan saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@include('modalComponent.addPesananModal')
@include('modalComponent.addCustomerModal')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Line Chart — Monthly Trend
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    const lineGradient = lineCtx.createLinearGradient(0, 0, 0, 300);
    lineGradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)'); // blue-600
    lineGradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: @json($monthlyLabels),
            datasets: [{
                label: 'Pesanan Masuk',
                data: @json($monthlyData),
                borderColor: '#2563eb', // blue-600
                backgroundColor: lineGradient,
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#2563eb',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b', // slate-800
                    titleFont: { family: 'Inter', size: 13, weight: '600' },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Inter', size: 12 },
                        color: '#64748b', // slate-500
                        maxRotation: 45,
                    },
                    border: { display: false }
                },
                y: {
                    grid: {
                        color: '#f1f5f9', // slate-100
                        drawBorder: false,
                    },
                    ticks: {
                        font: { family: 'Inter', size: 12 },
                        color: '#64748b',
                        stepSize: 1,
                    },
                    border: { display: false },
                    beginAtZero: true,
                }
            }
        }
    });

    // Doughnut Chart — Status
    const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
    new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Antrian (Pending)', 'Selesai'],
            datasets: [{
                data: [{{ $statusPending }}, {{ $statusSelesai }}],
                backgroundColor: ['#3b82f6', '#10b981'], // blue-500, emerald-500
                borderColor: '#ffffff',
                borderWidth: 4,
                hoverOffset: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { family: 'Inter', size: 13, weight: '500' },
                        color: '#475569', // slate-600
                        padding: 20,
                        usePointStyle: true,
                        pointStyleWidth: 12,
                    }
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleFont: { family: 'Inter', size: 13, weight: '600' },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                }
            }
        }
    });
});
</script>
@endpush
