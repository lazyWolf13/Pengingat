@extends('layouts.dashboard')

@section('content')
<div class="modern-background">
    <div class="wave"></div>
    <div class="wave"></div>
    <div class="wave"></div>
</div>

<div class="container-fluid px-4 position-relative">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-info">
                    <div class="stat-card-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h6 class="stat-card-title">Total Karyawan</h6>
                        <h3 class="stat-card-number">{{ $totalKaryawan }}</h3>
                    </div>
                </div>
                <div class="stat-card-chart">
                    <div class="chart-line"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-info">
                    <div class="stat-card-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h6 class="stat-card-title">Hadir Bulan Ini</h6>
                        <h3 class="stat-card-number">{{ $totalHadir }}</h3>
                    </div>
                </div>
                <div class="stat-card-chart">
                    <div class="chart-line success"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-info">
                    <div class="stat-card-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h6 class="stat-card-title">Total Terlambat</h6>
                        <h3 class="stat-card-number">{{ $totalTerlambat }}</h3>
                    </div>
                </div>
                <div class="stat-card-chart">
                    <div class="chart-line warning"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-info">
                    <div class="stat-card-icon bg-info">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h6 class="stat-card-title">Total Cuti</h6>
                        <h3 class="stat-card-number">{{ $totalCuti }}</h3>
                    </div>
                </div>
                <div class="stat-card-chart">
                    <div class="chart-line info"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="content-card">
        <div class="content-header">
            <div>
                <h4 class="content-title">Ringkasan Absensi</h4>
                <p class="content-subtitle">Kelola data kehadiran karyawan</p>
            </div>
            <button type="button" class="btn-generate" data-toggle="modal" data-target="#generateModal">
                <i class="fas fa-plus"></i>
                <span>Generate Ringkasan</span>
            </button>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari karyawan...">
            </div>
            <div class="filter-group">
                <select class="custom-select">
                    <option>Semua Departemen</option>
                    <option>IT</option>
                    <option>HR</option>
                    <option>Finance</option>
                </select>
                <select class="custom-select">
                    <option>Status</option>
                    <option>Hadir</option>
                    <option>Terlambat</option>
                    <option>Cuti</option>
                </select>
                <button class="btn-filter">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive modern-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Periode</th>
                        <th>Kehadiran</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($summaries as $summary)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="employee-avatar">
                                    {{ strtoupper(substr($summary->user->name, 0, 1)) }}
                                </div>
                                <div class="employee-info">
                                    <h6 class="employee-name">{{ $summary->user->name }}</h6>
                                    <span class="employee-position">{{ $summary->user->position ?? 'Staff' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="period-badge">
                                {{ date('F', mktime(0, 0, 0, $summary->bulan, 1)) }} {{ $summary->tahun }}
                            </div>
                        </td>
                        <td>
                            <div class="attendance-stats">
                                <div class="stat-item">
                                    <i class="fas fa-check text-success"></i>
                                    <span>{{ $summary->total_hadir }}</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-clock text-warning"></i>
                                    <span>{{ $summary->total_terlambat }}</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-user-clock text-info"></i>
                                    <span>{{ $summary->total_lembur ? $summary->total_lembur->format('H:i') : '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $status = 'success';
                                $statusText = 'Baik';
                                if($summary->total_terlambat > 3) {
                                    $status = 'warning';
                                    $statusText = 'Perhatian';
                                }
                                if($summary->total_terlambat > 5) {
                                    $status = 'danger';
                                    $statusText = 'Kritis';
                                }
                            @endphp
                            <span class="status-badge {{ $status }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td>
                            <div class="progress-wrapper">
                                @php
                                    $workDays = 22; // Asumsi 22 hari kerja
                                    $progress = ($summary->total_hadir / $workDays) * 100;
                                @endphp
                                <div class="progress">
                                    <div class="progress-bar bg-{{ $status }}" 
                                         role="progressbar" 
                                         style="width: {{ $progress }}%">
                                    </div>
                                </div>
                                <span class="progress-text">{{ number_format($progress, 0) }}%</span>
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="modern-pagination">
            {{ $summaries->links() }}
        </div>
    </div>
</div>

<!-- Generate Modal -->
<div class="modal fade" id="generateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Ringkasan Baru</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.summariesgenerate') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Periode</label>
                        <div class="period-selector">
                            <select name="bulan" class="form-control">
                                @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ date('n') == $month ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="tahun" class="form-control">
                                @foreach(range(date('Y')-5, date('Y')) as $year)
                                    <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-generate">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Modern Background dengan Soft Blue */
.modern-background {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    overflow: hidden;
    z-index: -1;
    background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
}

.wave {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0.4;
    background: linear-gradient(to right, #64B5F6, #2196F3);
    clip-path: polygon(100% 0%, 0% 0%, 0% 65%, 1% 64.95%, 2% 64.8%, 3% 64.6%, 4% 64.3%, 5% 63.9%, 6% 63.45%, 7% 62.9%, 8% 62.25%, 9% 61.55%, 10% 60.8%, 11% 59.95%, 12% 59.05%, 13% 58.1%, 14% 57.1%, 15% 56.05%, 16% 55%, 17% 53.9%, 18% 52.8%, 19% 51.65%, 20% 50.5%, 21% 49.35%, 22% 48.2%, 23% 47.05%, 24% 45.9%, 25% 44.8%, 26% 43.75%, 27% 42.75%, 28% 41.8%, 29% 40.9%, 30% 40.05%, 31% 39.3%, 32% 38.65%, 33% 38.05%, 34% 37.55%, 35% 37.15%, 36% 36.85%, 37% 36.6%, 38% 36.45%, 39% 36.4%, 40% 36.45%, 41% 36.6%, 42% 36.85%, 43% 37.15%, 44% 37.55%, 45% 38.05%, 46% 38.65%, 47% 39.3%, 48% 40.05%, 49% 40.9%, 50% 41.8%, 51% 42.75%, 52% 43.75%, 53% 44.8%, 54% 45.9%, 55% 47.05%, 56% 48.2%, 57% 49.35%, 58% 50.5%, 59% 51.65%, 60% 52.8%, 61% 53.9%, 62% 55%, 63% 56.05%, 64% 57.1%, 65% 58.1%, 66% 59.05%, 67% 59.95%, 68% 60.8%, 69% 61.55%, 70% 62.25%, 71% 62.9%, 72% 63.45%, 73% 63.9%, 74% 64.3%, 75% 64.6%, 76% 64.8%, 77% 64.95%, 78% 65%, 79% 64.95%, 80% 64.8%, 81% 64.6%, 82% 64.3%, 83% 63.9%, 84% 63.45%, 85% 62.9%, 86% 62.25%, 87% 61.55%, 88% 60.8%, 89% 59.95%, 90% 59.05%, 91% 58.1%, 92% 57.1%, 93% 56.05%, 94% 55%, 95% 53.9%, 96% 52.8%, 97% 51.65%, 98% 50.5%, 99% 49.35%, 100% 48.2%);
    animation: wave 15s linear infinite;
}

.wave:nth-child(2) {
    animation-delay: -5s;
    opacity: 0.2;
}

.wave:nth-child(3) {
    animation-delay: -10s;
    opacity: 0.1;
}

@keyframes wave {
    0% {
        transform: translateX(0) translateZ(0) scaleY(1);
    }
    50% {
        transform: translateX(-25%) translateZ(0) scaleY(0.55);
    }
    100% {
        transform: translateX(-50%) translateZ(0) scaleY(1);
    }
}

/* Stat Cards */
.stat-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    margin-bottom: 1rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(33, 150, 243, 0.15);
}

.stat-card-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.stat-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-card-title {
    color: #6e6e6e;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.stat-card-number {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
}

/* Content Card */
.content-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
}

.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.content-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
}

.content-subtitle {
    color: #6e6e6e;
    margin: 0.25rem 0 0;
}

/* Buttons */
.btn-generate {
    background: linear-gradient(135deg, #2196F3 0%, #1565C0 100%);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-generate:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
}

/* Filter Section */
.filter-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    gap: 1rem;
}

.search-box {
    position: relative;
    flex: 1;
}

.search-box input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid rgba(33, 150, 243, 0.2);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6e6e6e;
}

.filter-group {
    display: flex;
    gap: 0.75rem;
}

.custom-select {
    padding: 0.75rem 1rem;
    border: 1px solid rgba(33, 150, 243, 0.2);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.9);
}

/* Table Styles */
.modern-table {
    margin: 0 -1.5rem;
}

.table {
    margin: 0;
}

.table th {
    background: rgba(33, 150, 243, 0.1);
    color: #1565C0;
    font-weight: 600;
    padding: 1rem 1.5rem;
    border: none;
}

.table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}

.employee-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #2196F3 0%, #1565C0 100%);
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-right: 1rem;
}

.employee-info {
    line-height: 1.2;
}

.employee-name {
    margin: 0;
    font-weight: 600;
}

.employee-position {
    font-size: 0.875rem;
    color: #6e6e6e;
}

.period-badge {
    background: rgba(33, 150, 243, 0.1);
    color: #1565C0;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    display: inline-block;
}

.attendance-stats {
    display: flex;
    gap: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-badge.success {
    background: rgba(76, 175, 80, 0.1);
    color: #2E7D32;
}

.status-badge.warning {
    background: rgba(255, 152, 0, 0.1);
    color: #EF6C00;
}

.status-badge.danger {
    background: rgba(244, 67, 54, 0.1);
    color: #D32F2F;
}

.progress-wrapper {
    width: 150px;
}

.progress {
    height: 8px;
    background: #f0f0f0;
    border-radius: 4px;
    margin-bottom: 0.25rem;
}

.progress-text {
    font-size: 0.875rem;
    color: #6e6e6e;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: all 0.2s ease;
}

.btn-action.view {
    background: #2196F3;
}

.btn-action.edit {
    background: #00BCD4;
}

.btn-action.delete {
    background: #F44336;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Modal Styles */
.modal-content {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(33, 150, 243, 0.2);
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.modal-header {
    border-bottom: 1px solid rgba(33, 150, 243, 0.1);
    padding: 1.5rem;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid rgba(33, 150, 243, 0.1);
    padding: 1.5rem;
}

.period-selector {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    padding: 1rem;
    background: rgba(33, 150, 243, 0.03);
    border: 1px solid rgba(33, 150, 243, 0.1);
    border-radius: 12px;
}

.period-selector select {
    border: 1px solid rgba(33, 150, 243, 0.2);
    border-radius: 8px;
    padding: 0.75rem;
    background: white;
    transition: all 0.3s ease;
}

.period-selector select:focus {
    border-color: #2196F3;
    box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.1);
    outline: none;
}

.form-group label {
    font-weight: 500;
    color: #1565C0;
    margin-bottom: 0.75rem;
}

/* Style untuk tombol di modal */
.btn-cancel {
    background: rgba(0, 0, 0, 0.05);
    color: #666;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-generate {
    background: linear-gradient(135deg, #2196F3 0%, #1565C0 100%);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

.btn-generate:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
}

/* Hover effect untuk modal */
.modal-content:hover {
    border-color: rgba(33, 150, 243, 0.4);
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

/* Responsive Design */
@media (max-width: 768px) {
    .filter-section {
        flex-direction: column;
    }
    
    .filter-group {
        width: 100%;
        overflow-x: auto;
    }
    
    .attendance-stats {
        flex-direction: column;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form handling
    const generateForm = document.querySelector('#generateModal form');
    const submitBtn = generateForm.querySelector('button[type="submit"]');
    const tableBody = document.querySelector('tbody');

    generateForm.addEventListener('submit', function(e) {
        e.preventDefault();
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generating...';
        
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update table dengan data baru
                updateTable(data.summaries);
                // Tampilkan pesan sukses
                showAlert('success', 'Ringkasan absensi berhasil digenerate');
                // Tutup modal
                $('#generateModal').modal('hide');
            } else {
                showAlert('error', 'Terjadi kesalahan: ' + data.message);
            }
        })
        .catch(error => {
            showAlert('error', 'Terjadi kesalahan sistem');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Generate';
        });
    });

    function updateTable(summaries) {
        tableBody.innerHTML = '';
        summaries.forEach(summary => {
            const workDays = 22;
            const progress = (summary.total_hadir / workDays) * 100;
            let status = 'success';
            let statusText = 'Baik';
            
            if(summary.total_terlambat > 3) {
                status = 'warning';
                statusText = 'Perhatian';
            }
            if(summary.total_terlambat > 5) {
                status = 'danger';
                statusText = 'Kritis';
            }

            const row = `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="employee-avatar">
                                ${summary.user.name.charAt(0).toUpperCase()}
                            </div>
                            <div class="employee-info">
                                <h6 class="employee-name">${summary.user.name}</h6>
                                <span class="employee-position">${summary.user.position || 'Staff'}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="period-badge">
                            ${new Date(2024, summary.bulan - 1).toLocaleString('default', { month: 'long' })} ${summary.tahun}
                        </div>
                    </td>
                    <td>
                        <div class="attendance-stats">
                            <div class="stat-item">
                                <i class="fas fa-check text-success"></i>
                                <span>${summary.total_hadir}</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-clock text-warning"></i>
                                <span>${summary.total_terlambat}</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-user-clock text-info"></i>
                                <span>${summary.total_lembur || '-'}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge ${status}">
                            ${statusText}
                        </span>
                    </td>
                    <td>
                        <div class="progress-wrapper">
                            <div class="progress">
                                <div class="progress-bar bg-${status}" 
                                     role="progressbar" 
                                     style="width: ${progress}%">
                                </div>
                            </div>
                            <span class="progress-text">${Math.round(progress)}%</span>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action view" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-action edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action delete" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    }

    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show mb-4`;
        alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle mr-2"></i>
                ${message}
            </div>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        `;
        
        const container = document.querySelector('.container-fluid');
        container.insertBefore(alertDiv, container.firstChild);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const name = row.querySelector('.employee-name').textContent.toLowerCase();
                row.style.display = name.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Filter functionality
    const filterSelects = document.querySelectorAll('.custom-select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Add your filter logic here
        });
    });
});
</script>
@endpush
@endsection 