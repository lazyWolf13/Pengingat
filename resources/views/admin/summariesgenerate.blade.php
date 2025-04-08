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
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div>
                        <h6 class="stat-card-title">Periode</h6>
                        <h3 class="stat-card-number" id="selectedPeriod">-</h3>
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
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h6 class="stat-card-title">Total Karyawan</h6>
                        <h3 class="stat-card-number" id="totalEmployees">{{ $totalKaryawan }}</h3>
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
                    <div class="stat-card-icon bg-info">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h6 class="stat-card-title">Hari Kerja</h6>
                        <h3 class="stat-card-number">22</h3>
                    </div>
                </div>
                <div class="stat-card-chart">
                    <div class="chart-line info"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-info">
                    <div class="stat-card-icon bg-warning">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <div>
                        <h6 class="stat-card-title">Status</h6>
                        <h3 class="stat-card-number" id="generateStatus">Siap</h3>
                    </div>
                </div>
                <div class="stat-card-chart">
                    <div class="chart-line warning"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="content-card">
        <div class="content-header">
            <div>
                <h4 class="content-title">Generate Ringkasan Absensi</h4>
                <p class="content-subtitle">Generate ringkasan absensi karyawan berdasarkan periode</p>
            </div>
            <a href="{{ route('admin.summaries.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('admin.summariesgenerate') }}" method="POST" id="generateForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                Pilih Periode
                            </h5>
                            <div class="period-selector">
                                <select name="bulan" class="form-control" required>
                                    @foreach(range(1, 12) as $month)
                                        <option value="{{ $month }}" {{ date('n') == $month ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="tahun" class="form-control" required>
                                    @foreach(range(date('Y')-5, date('Y')) as $year)
                                        <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-section mt-4">
                            <h5 class="section-title">
                                <i class="fas fa-building text-success mr-2"></i>
                                Filter Departemen
                            </h5>
                            <select name="department" class="form-control">
                                <option value="">Semua Departemen</option>
                                <option value="IT">IT</option>
                                <option value="HR">HR</option>
                                <option value="Finance">Finance</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="preview-card">
                            <h5 class="preview-title">
                                <i class="fas fa-info-circle text-info mr-2"></i>
                                Informasi Generate
                            </h5>
                            <div class="info-grid">
                                <div class="info-item">
                                    <i class="fas fa-users text-primary"></i>
                                    <div class="info-content">
                                        <span class="info-label">Total Karyawan</span>
                                        <span class="info-value" id="previewEmployees">{{ $totalKaryawan }}</span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-calendar-check text-success"></i>
                                    <div class="info-content">
                                        <span class="info-label">Hari Kerja</span>
                                        <span class="info-value">22 hari</span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-clock text-warning"></i>
                                    <div class="info-content">
                                        <span class="info-label">Status Generate</span>
                                        <span class="info-value" id="previewStatus">Siap Generate</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="history.back()">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-generate" id="generateBtn">
                        <i class="fas fa-sync-alt mr-2"></i>Generate Ringkasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Existing styles from summaries.blade.php */
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

/* Stats Cards */
.stat-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(33, 150, 243, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

/* Content Card */
.content-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(33, 150, 243, 0.2);
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

/* Form Sections */
.form-section {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid rgba(33, 150, 243, 0.1);
}

.section-title {
    font-size: 1.1rem;
    color: #1565C0;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

/* Preview Card */
.preview-card {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid rgba(33, 150, 243, 0.1);
    height: 100%;
}

.info-grid {
    display: grid;
    gap: 1rem;
    margin-top: 1rem;
}

.info-item {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

/* Buttons */
.btn-generate {
    background: linear-gradient(135deg, #2196F3 0%, #1565C0 100%);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-cancel {
    background: rgba(0, 0, 0, 0.05);
    color: #666;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    margin-right: 1rem;
    transition: all 0.3s ease;
}

.form-actions {
    margin-top: 2rem;
    display: flex;
    justify-content: flex-end;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 8px;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('generateForm');
    const generateBtn = document.getElementById('generateBtn');
    const generateStatus = document.getElementById('generateStatus');
    const previewStatus = document.getElementById('previewStatus');
    const totalEmployees = document.getElementById('totalEmployees');
    const previewEmployees = document.getElementById('previewEmployees');
    const selectedPeriod = document.getElementById('selectedPeriod');

    // Update period display
    function updatePeriod() {
        const month = document.querySelector('select[name="bulan"] option:checked').text;
        const year = document.querySelector('select[name="tahun"]').value;
        selectedPeriod.textContent = `${month} ${year}`;
    }

    // Initial period update
    updatePeriod();

    // Listen for period changes
    document.querySelector('select[name="bulan"]').addEventListener('change', updatePeriod);
    document.querySelector('select[name="tahun"]').addEventListener('change', updatePeriod);

    // Hapus event listener untuk department change yang menggunakan random number
    // dan ganti dengan nilai tetap dari database
    const totalKaryawan = {{ $totalKaryawan }};
    document.querySelector('select[name="department"]').addEventListener('change', function(e) {
        if (e.target.value === '') {
            // Jika "Semua Departemen" dipilih, tampilkan total keseluruhan
            totalEmployees.textContent = totalKaryawan;
            previewEmployees.textContent = totalKaryawan;
        } else {
            // Di sini Anda bisa menambahkan AJAX call untuk mendapatkan 
            // jumlah karyawan per departemen jika diperlukan
            fetch(`/admin/users/count-by-department/${e.target.value}`)
                .then(response => response.json())
                .then(data => {
                    totalEmployees.textContent = data.count;
                    previewEmployees.textContent = data.count;
                });
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        generateBtn.disabled = true;
        generateStatus.textContent = 'Proses';
        previewStatus.textContent = 'Sedang Memproses...';
        generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generating...';

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
                generateStatus.textContent = 'Selesai';
                previewStatus.textContent = 'Berhasil Generate!';
                window.location.href = '{{ route("admin.summaries.index") }}';
            } else {
                generateStatus.textContent = 'Gagal';
                previewStatus.textContent = 'Gagal: ' + data.message;
                alert('Terjadi kesalahan: ' + data.message);
            }
        })
        .catch(error => {
            generateStatus.textContent = 'Error';
            previewStatus.textContent = 'Gagal Generate';
            alert('Terjadi kesalahan sistem');
        })
        .finally(() => {
            generateBtn.disabled = false;
            generateBtn.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Generate Ringkasan';
        });
    });
});
</script>
@endpush
@endsection 