@extends('layouts.app')

@section('title', 'Dashboard - Audify')

@push('styles')
<style>
    .active-device-card {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 6px 20px rgba(40,167,69,0.25);
        margin-bottom: 30px;
    }

    .classification-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.06);
        margin-top: 25px;
    }

    .ear-classification-box {
        background: #f9fafb;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        transition: transform 0.2s;
    }
    .ear-classification-box:hover {
        transform: translateY(-3px);
    }

    .ear-classification-box.right { border-left: 6px solid #cc0000; }   /* Kanan = Merah */
    .ear-classification-box.left  { border-left: 6px solid #0066cc; }   /* Kiri = Biru */

    .hearing-stat-value {
        font-size: 2.4rem;
        font-weight: 800;
        line-height: 1;
        color: #1f2937;
    }

    .classification-badge {
        font-size: 1.15rem;
        padding: 10px 24px;
        border-radius: 9999px;
        font-weight: 700;
        display: inline-block;
    }

    .small-box {
        border-radius: 15px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .small-box:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.12);
    }

    .menu-card {
        transition: all 0.3s;
        cursor: pointer;
        border-radius: 15px;
        border: none;
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
        height: 100%;
    }
    .menu-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }

    .menu-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .chart-container {
        position: relative;
        height: 350px;   
        width: 100%;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin: 0 16px;
    }
    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .device-selector {
        background: rgba(255,255,255,0.25);
        border: 2px dashed white;
        border-radius: 9999px;
        padding: 8px 20px 8px 30px;
        color: white;
        font-size: 1.35rem;
        font-weight: 700;
        cursor: pointer;
        appearance: none;
        min-width: 320px;
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 18px;
    }
    .device-selector option {
        background: #15803d;
        color: white;
        padding: 12px;
    }
</style>
@endpush

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-6">
                <h1 class="mb-0">Dashboard Audify</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        <!-- Statistik Utama -->
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalPasien ?? 0 }}</h3>
                        <p>Total Pasien</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <a href="{{ route('patients.index') }}" class="small-box-footer">
                        Kelola Pasien <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalPemeriksaan ?? 0 }}</h3>
                        <p>Total Pemeriksaan</p>
                    </div>
                    <div class="icon"><i class="fas fa-stethoscope"></i></div>
                    <a href="{{ route('examination.index') }}" class="small-box-footer">
                        Lihat Semua <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $pemeriksaanHariIni ?? 0 }}</h3>
                        <p>Pemeriksaan Hari Ini</p>
                    </div>
                    <div class="icon"><i class="fas fa-calendar-check"></i></div>
                    <a href="{{ route('examination.index', ['filter' => 'hari_ini']) }}" class="small-box-footer">
                        Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!--Selamat Datang-->
        <div class="row">
            <div class="col-12">
                <div class="active-device-card">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center flex-grow-1">
                            <div class="mr-4 d-none d-md-block">
                                <i class="fas fa-microphone-alt fa-4x"></i>
                            </div>
                            <div>
                                <h3 class="mb-1">Selamat Datang, <strong>{{ Auth::user()->username ?? Auth::user()->name ?? 'Pengguna' }}</strong>!</h3>
                                <p class="mb-2 opacity-90">Alat audiometer aktif:</p>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <i class="fas fa-microphone mr-2"></i>
                                    <select id="deviceSelector" class="device-selector">
                                        @forelse($devices as $device)
                                            <option value="{{ $device->id }}"
                                                {{ ($activeDevice?->id ?? null) == $device->id ? 'selected' : '' }}>
                                                {{ $device->kode_alat }} — {{ $device->nama_alat }}
                                            </option>
                                        @empty
                                            <option value="">Tidak ada audiometer</option>
                                        @endforelse
                                    </select>

                                    {{-- <button class="btn btn-sm btn-warning btn-device-action" onclick="editDevice()" title="Edit alat">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-device-action" onclick="hapusDevice()" title="Hapus alat">
                                        <i class="fas fa-trash"></i>
                                    </button> --}}
                                </div>
                                <p class="mt-2 mb-0" id="activeLocation">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $activeDevice->lokasi ?? 'Lokasi belum diatur' }}
                                </p>
                            </div>
                        </div>

                        {{-- <button class="btn btn-tambah-audiometer" data-toggle="modal" data-target="#modalTambahAudiometer">
                            <i class="fas fa-plus-circle mr-2"></i>Tambah Audiometer
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Audiogram -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card card-outline shadow-sm">
                    <div class="card-header" style="background-color: #cc0000; color: white;">
                        <h5 class="mb-0">
                            <i class="fas fa-ear-listen mr-2"></i>Audiogram Telinga Kanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="audiogramRightChart"></canvas>
                        </div>
                        <div class="d-flex justify-content-center mt-4 gap-4">
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #cc0000;"></div>
                                <small>Air Conduction</small>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #f59e0b;"></div>
                                <small>Bone Conduction</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-outline shadow-sm">
                    <div class="card-header" style="background-color: #0066cc; color: white;">
                        <h5 class="mb-0">
                            <i class="fas fa-ear-listen mr-2"></i>Audiogram Telinga Kiri
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="audiogramLeftChart"></canvas>
                        </div>
                        <div class="d-flex justify-content-center mt-4 gap-4">
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #0066cc;"></div>
                                <small>Air Conduction</small>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #10b981;"></div>
                                <small>Bone Conduction</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hasil Klasifikasi -->
        @if($grafikData['pasien'] ?? false)
        <div class="row mt-4">
            <div class="col-12">
                <div class="classification-card shadow-sm">
                    <h4 class="mb-3">
                        <i class="fas fa-clipboard-check mr-2 text-primary"></i>
                        Hasil Klasifikasi Gangguan Pendengaran
                    </h4>
                    <p class="text-muted mb-4">
                        Pasien: <strong>{{ $grafikData['pasien']->nama ?? '—' }}</strong> 
                        (No. RM: {{ $grafikData['pasien']->no_rm ?? '—' }})
                    </p>

                    <div class="row g-4">
                        <!-- Telinga Kanan -->
                        <div class="col-md-6">
                            <div class="ear-classification-box right">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0 text-primary">
                                        <i class="fas fa-arrow-right mr-2"></i>Telinga Kanan
                                    </h5>
                                    <span class="badge bg-primary px-3 py-2">PTA: {{ $grafikData['pasien']->pta_kanan ?? '—' }} dB</span>
                                </div>

                                <div class="text-center mb-3">
                                    <div class="hearing-stat-value d-inline-block">
                                        {{ $grafikData['pasien']->pta_kanan ?? '—' }}
                                    </div>
                                    <small class="text-muted d-block">dB HL</small>
                                </div>

                                @php
                                    $klasKanan = $grafikData['pasien']->klasifikasi_kanan ?? 'Normal';
                                    $classKanan = match(true) {
                                        str_contains($klasKanan, 'Normal') => 'bg-success',
                                        str_contains($klasKanan, 'Ringan') => 'bg-warning text-dark',
                                        str_contains($klasKanan, 'Sedang') => 'bg-warning text-dark',
                                        str_contains($klasKanan, 'Sedang-Berat') => 'bg-warning text-dark',
                                        str_contains($klasKanan, 'Berat') || str_contains($klasKanan, 'Sangat') => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <div class="text-center">
                                    <span class="classification-badge {{ $classKanan }}">
                                        {{ $klasKanan }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Telinga Kiri -->
                        <div class="col-md-6">
                            <div class="ear-classification-box left">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0 text-danger">
                                        <i class="fas fa-arrow-left mr-2"></i>Telinga Kiri
                                    </h5>
                                    <span class="badge bg-danger px-3 py-2">PTA: {{ $grafikData['pasien']->pta_kiri ?? '—' }} dB</span>
                                </div>

                                <div class="text-center mb-3">
                                    <div class="hearing-stat-value d-inline-block">
                                        {{ $grafikData['pasien']->pta_kiri ?? '—' }}
                                    </div>
                                    <small class="text-muted d-block">dB HL</small>
                                </div>

                                @php
                                    $klasKiri = $grafikData['pasien']->klasifikasi_kiri ?? 'Normal';
                                    $classKiri = match(true) {
                                        str_contains($klasKiri, 'Normal') => 'bg-success',
                                        str_contains($klasKiri, 'Ringan') => 'bg-warning text-dark',
                                        str_contains($klasKiri, 'Sedang') => 'bg-warning text-dark',
                                        str_contains($klasKiri, 'Sedang-Berat') => 'bg-warning text-dark',
                                        str_contains($klasKiri, 'Berat') || str_contains($klasKiri, 'Sangat') => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <div class="text-center">
                                    <span class="classification-badge {{ $classKiri }}">
                                        {{ $klasKiri }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="alert alert-info d-flex align-items-center mb-0">
                            <i class="fas fa-stethoscope fa-2x mr-3"></i>
                            <div>
                                <strong>Diagnosis:</strong> 
                                {{ $grafikData['pasien']->diagnosis ?? 'Belum ada diagnosis' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Menu Shortcut -->
        <div class="row mt-5">
            @foreach([
                ['route' => 'patients.index', 'icon' => 'fa-user-plus', 'color' => 'info', 'title' => 'Manajemen Pasien', 'desc' => 'Kelola data pasien'],
                ['route' => 'examination.index', 'icon' => 'fa-stethoscope', 'color' => 'success', 'title' => 'Pemeriksaan', 'desc' => 'Hasil audiometri & riwayat'],
                ['route' => 'laporan.index', 'icon' => 'fa-chart-bar', 'color' => 'warning', 'title' => 'Laporan', 'desc' => 'Statistik & export data'],
            ] as $menu)
            <div class="col-lg-4 mb-4">
                <div class="menu-card shadow-sm" onclick="location.href='{{ route($menu['route']) }}'">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="menu-icon bg-{{ $menu['color'] }} text-white mr-4">
                            <i class="fas {{ $menu['icon'] }}"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $menu['title'] }}</h5>
                            <p class="text-muted mb-0 small">{{ $menu['desc'] }}</p>
                        </div>
                        <i class="fas fa-chevron-right text-muted ml-auto"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Informasi Ringkasan Pemeriksaan Terbaru -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-clock mr-2 text-primary"></i>Pemeriksaan Terbaru
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('examination.index') }}" class="btn btn-sm btn-primary">
                                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>No. RM</th>
                                        <th>Pasien</th>
                                        <th>PTA Kanan</th>
                                        <th>PTA Kiri</th>
                                        <th>Klasifikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pemeriksaanTerbaru ?? [] as $exam)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($exam->tanggal)->format('d M Y') }}</td>
                                        
                                        <!-- No. RM & Nama dari relasi patient -->
                                        <td>
                                            <span class="badge badge-primary">{{ $exam->patient->no_rm ?? '-' }}</span>
                                        </td>
                                        <td><strong>{{ $exam->patient->nama ?? '—' }}</strong></td>
                                        
                                        <td>{{ $exam->pta_kanan ? $exam->pta_kanan . ' dB' : '—' }}</td>
                                        <td>{{ $exam->pta_kiri ? $exam->pta_kiri . ' dB' : '—' }}</td>
                                        
                                        <td>
                                            @php
                                                $kKanan = $exam->klasifikasi_kanan ?? '—';
                                                $kKiri  = $exam->klasifikasi_kiri  ?? '—';
                                                $cKanan = match(true) {
                                                    str_contains($kKanan, 'Normal') => 'success',
                                                    str_contains($kKanan, 'Ringan') || str_contains($kKanan, 'Sedang') => 'warning',
                                                    default => 'danger',
                                                };
                                                $cKiri = match(true) {
                                                    str_contains($kKiri, 'Normal') => 'success',
                                                    str_contains($kKiri, 'Ringan') || str_contains($kKiri, 'Sedang') => 'warning',
                                                    default => 'danger',
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $cKanan }}">{{ $kKanan }}</span> /
                                            <span class="badge bg-{{ $cKiri }}">{{ $kKiri }}</span>
                                        </td>
                                        
                                        <td>
                                            @if($exam->patient && $exam->patient->no_rm)
                                                <a href="{{ route('laporan.cetak', $exam->patient->no_rm) }}" 
                                                class="btn btn-sm btn-outline-primary" 
                                                target="_blank">
                                                    <i class="fas fa-file-pdf"></i> Cetak
                                                </a>
                                            @else
                                                <span class="text-muted small">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fas fa-history fa-3x mb-3 d-block"></i>
                                            Belum ada pemeriksaan terbaru
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Modal Tambah Audiometer -->
<div class="modal fade" id="modalTambahAudiometer" tabindex="-1" role="dialog" aria-labelledby="modalTambahAudiometerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalTambahAudiometerLabel">
                    <i class="fas fa-microphone-alt mr-2"></i>Tambah Audiometer Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formTambahAudiometer" action="{{ route('devices.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kode Audiometer <span class="text-danger">*</span></label>
                            <input type="text" name="kode_alat" class="form-control" placeholder="Contoh: AUD-007" value="AUD-" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Audiometer <span class="text-danger">*</span></label>
                            <input type="text" name="nama_alat" class="form-control" placeholder="Contoh: Audiometer B-200" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" list="lokasiList" placeholder="Ruang Audiologi">
                            <datalist id="lokasiList">
                                <option value="Ruang Audiologi">
                                <option value="Ruang THT">
                                <option value="Ruang Bayi">
                                <option value="Poli Umum">
                            </datalist>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Kalibrasi</label>
                            <input type="date" name="tanggal_kalibrasi" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Tersedia" selected>Tersedia</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Kalibrasi">Kalibrasi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun Pengadaan</label>
                            <input type="number" name="tahun_pengadaan" class="form-control" min="2000" max="{{ date('Y') }}" placeholder="{{ date('Y') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSimpanAudiometer" class="btn btn-info">
                        <i class="fas fa-save me-2"></i>Simpan Audiometer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const frequencies = [125,250,500,750,1000,1500,2000,3000,4000,6000,8000,12000];
    
    const labels = frequencies.map(f => {
        if (f === 125) return '125';
        if (f === 250) return '250';
        if (f === 500) return '500';
        if (f === 750) return '750';
        if (f === 1000) return '1000';
        if (f === 1500) return '1500';
        if (f === 2000) return '2000';
        if (f === 3000) return '3000';
        if (f === 4000) return '4000';
        if (f === 6000) return '6000';
        if (f === 8000) return '8000';
        if (f === 12000) return '12000';
        return '';
    });

    const rightAC = @json($grafikData['rightAC'] ?? array_fill(0, 13, null));
    const rightBC = @json($grafikData['rightBC'] ?? array_fill(0, 13, null));
    const leftAC  = @json($grafikData['leftAC']  ?? array_fill(0, 13, null));
    const leftBC  = @json($grafikData['leftBC']  ?? array_fill(0, 13, null));

    const patientName = '{{ addslashes($grafikData['pasien']?->nama ?? "Belum ada data") }}';

    const createChart = (canvasId, acData, bcData, titleText, colorAC, colorBC, isRight) => {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return;

        new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Air Conduction (AC)',
                        data: acData,
                        borderColor: colorAC,
                        backgroundColor: colorAC + '22',
                        borderWidth: 3.5,
                        tension: 0.25,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        pointStyle: isRight ? 'circle' : 'cross'   // Lingkaran untuk kanan, Silang untuk kiri
                    },
                    {
                        label: 'Bone Conduction (BC)',
                        data: bcData,
                        borderColor: colorBC,
                        borderDash: [6, 4],
                        borderWidth: 3,
                        tension: 0.25,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: { 
                        display: true, 
                        text: titleText, 
                        font: { size: 16, weight: 'bold' } 
                    },
                    legend: { 
                        position: 'top',
                        labels: { padding: 20, boxWidth: 15, font: { size: 13 } }
                    }
                },
                scales: {
                    y: {
                        title: { display: true, text: 'dB HL' },
                        min: -10,
                        max: 120,
                        reverse: true,
                        ticks: { stepSize: 10 },
                        grid: { color: 'rgba(0,0,0,0.09)' }
                    },
                    x: {
                        title: { display: true, text: 'Frekuensi (Hz)' },
                        grid: { color: 'rgba(0,0,0,0.07)' },
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            font: { size: 12 }
                        }
                    }
                }
            }
        });
    };

    createChart('audiogramRightChart', rightAC, rightBC, 
                `Telinga Kanan — ${patientName}`, 
                '#cc0000', '#f59e0b', true);   // AC = Merah, BC = Orange

    createChart('audiogramLeftChart', leftAC, leftBC, 
                `Telinga Kiri — ${patientName}`, 
                '#0066cc', '#10b981', false);  // AC = Biru, BC = Hijau
});
</script>
@endpush