{{-- file: laporan.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan Penjualan - POS Native')
@section('header-title', '')
@section('header-subtitle', '')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-orange-50/30 -m-4 md:-m-6 p-4 md:p-6 min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 animate-fade-in-up">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Laporan <span class="text-orange-600">Penjualan</span>
                </h1>
                <p class="text-base md:text-lg text-gray-600 mt-2 flex items-center gap-2">
                    <span class="inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Analisis performa penjualan • {{ now()->format('d F Y') }}
                </p>
            </div>

            {{-- Tombol Export --}}
            <button onclick="openExportModal()" class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-orange-500/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export Laporan
            </button>
        </div>

        {{-- Filter Tanggal --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8 animate-fade-in-up" style="animation-delay: 0.05s">
            <div class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" id="startDate" value="2026-04-05" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition">
                </div>
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" id="endDate" value="2026-04-11" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition">
                </div>
                <div>
                    <button onclick="applyFilter()" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-medium rounded-xl shadow-md shadow-orange-200 transition-all">
                        Filter
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== STATISTIK KARTU ===================== --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8 animate-fade-in-up" style="animation-delay: 0.08s">
            @php
                $reports = [
                    ['date' => 'Sab, 11 Apr 2026', 'sales' => 1250000, 'transactions' => 87, 'profit' => 625000, 'margin' => 50.0],
                    ['date' => 'Jum, 10 Apr 2026', 'sales' => 1120000, 'transactions' => 79, 'profit' => 560000, 'margin' => 50.0],
                    ['date' => 'Kam, 9 Apr 2026', 'sales' => 980000, 'transactions' => 71, 'profit' => 490000, 'margin' => 50.0],
                    ['date' => 'Rab, 8 Apr 2026', 'sales' => 1340000, 'transactions' => 92, 'profit' => 670000, 'margin' => 50.0],
                    ['date' => 'Sel, 7 Apr 2026', 'sales' => 1450000, 'transactions' => 98, 'profit' => 725000, 'margin' => 50.0],
                    ['date' => 'Sen, 6 Apr 2026', 'sales' => 1580000, 'transactions' => 105, 'profit' => 790000, 'margin' => 50.0],
                ];
                $totalSales = array_sum(array_column($reports, 'sales'));
                $totalTrans = array_sum(array_column($reports, 'transactions'));
                $totalProfit = array_sum(array_column($reports, 'profit'));
                $avgMargin = $totalSales > 0 ? round(($totalProfit / $totalSales) * 100, 1) : 0;
            @endphp

            {{-- Total Penjualan --}}
            <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-orange-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 font-medium tracking-wide text-sm">Total Penjualan</p>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 tracking-tight">Rp {{ number_format($totalSales, 0, ',', '.') }}</h2>
                        <p class="text-gray-400 text-xs mt-1">Periode terpilih</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-500 flex items-center justify-center shadow-md shadow-orange-200 group-hover:shadow-orange-300/50 transition-shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Transaksi --}}
            <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 font-medium tracking-wide text-sm">Total Transaksi</p>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 tracking-tight">{{ $totalTrans }}</h2>
                        <p class="text-gray-400 text-xs mt-1">Transaksi berhasil</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center shadow-md shadow-blue-200 group-hover:shadow-blue-300/50 transition-shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Laba --}}
            <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-green-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 font-medium tracking-wide text-sm">Total Laba</p>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 tracking-tight">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h2>
                        <p class="text-gray-400 text-xs mt-1">Margin rata-rata {{ $avgMargin }}%</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-400 to-green-500 flex items-center justify-center shadow-md shadow-green-200 group-hover:shadow-green-300/50 transition-shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Laporan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Penjualan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Transaksi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Laba</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Margin</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($reports as $item)
                        <tr class="hover:bg-orange-50/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $item['date'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($item['sales'], 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-700">{{ $item['transactions'] }} transaksi</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-green-600">Rp {{ number_format($item['profit'], 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-sm font-semibold {{ $item['margin'] >= 50 ? 'text-green-600' : 'text-orange-600' }}">
                                        {{ $item['margin'] }}%
                                    </span>
                                    <div class="w-12 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full {{ $item['margin'] >= 50 ? 'bg-green-500' : 'bg-orange-400' }}" style="width: {{ $item['margin'] }}%"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50/50 border-t border-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Total / Rata-rata</td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Rp {{ number_format($totalSales, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $totalTrans }} transaksi</td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-green-600">Rp {{ number_format($totalProfit, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $avgMargin }}%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="exportModal" class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity bg-black/30 backdrop-blur-sm" onclick="closeExportModal(event)">
    <div class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-2xl transform transition-all" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Export Laporan</h3>
                <button onclick="closeExportModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <p class="text-gray-600 mb-4">Pilih format file untuk mengunduh laporan periode <span id="exportDateRange" class="font-semibold text-gray-900"></span>.</p>

            <div class="grid grid-cols-2 gap-4">
                <button onclick="exportReport('pdf')" class="flex flex-col items-center gap-3 p-5 border-2 border-gray-200 rounded-xl hover:border-red-400 hover:bg-red-50 transition-all group">
                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center group-hover:bg-red-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-gray-800">PDF Document</span>
                    <span class="text-xs text-gray-500">.pdf</span>
                </button>

                <button onclick="exportReport('excel')" class="flex flex-col items-center gap-3 p-5 border-2 border-gray-200 rounded-xl hover:border-green-400 hover:bg-green-50 transition-all group">
                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center group-hover:bg-green-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-gray-800">Excel Spreadsheet</span>
                    <span class="text-xs text-gray-500">.xlsx</span>
                </button>
            </div>

            <div class="mt-5 pt-4 border-t border-gray-100 flex justify-end">
                <button onclick="closeExportModal()" class="px-5 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');

    function applyFilter() {
        const start = startDateInput.value;
        const end = endDateInput.value;
        alert(`Menampilkan laporan dari ${start} sampai ${end}`);

    }

    function openExportModal() {
        const start = startDateInput.value || '2026-04-05';
        const end = endDateInput.value || '2026-04-11';
        const formattedStart = new Date(start).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        const formattedEnd = new Date(end).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        document.getElementById('exportDateRange').textContent = `${formattedStart} - ${formattedEnd}`;
        document.getElementById('exportModal').classList.remove('hidden');
    }

    function closeExportModal(event) {
        if (!event || event.target === document.getElementById('exportModal')) {
            document.getElementById('exportModal').classList.add('hidden');
        }
    }

    function exportReport(format) {
        const start = startDateInput.value;
        const end = endDateInput.value;
        
        if (format === 'pdf') {
            alert(`Mengekspor laporan PDF dari ${start} sampai ${end}`);
        } else if (format === 'excel') {
            alert(`Mengekspor laporan Excel dari ${start} sampai ${end}`);
        }
        closeExportModal();
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeExportModal();
        }
    });

    window.addEventListener('DOMContentLoaded', () => {
        if (!startDateInput.value) startDateInput.value = '2026-04-05';
        if (!endDateInput.value) endDateInput.value = '2026-04-11';
    });
</script>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out; }
</style>
@endsection