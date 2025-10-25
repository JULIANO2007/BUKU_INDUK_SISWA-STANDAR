@extends('layouts.base')

@section('content')
    <div class="container-fluid px-4 py-4">
        <!-- Welcome Toast Notification -->
        <div id="welcome-notification" class="toast-notification alert alert-success shadow-sm border-0" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3 fs-2 text-success"></i>
                <div>
                    <h5 class="alert-heading mb-1 fw-bold">Selamat Datang, {{ $user->nama_lengkap }}!</h5>
                    <p class="mb-0">Dashboard pribadi siswa - Buku Induk Siswa</p>
                </div>
            </div>
        </div>

        <!-- Profile Photo and Basic Info -->
        <div class="row mb-4">
            <div class="col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <img src="@if ($user->foto === NULL) @if($user->jenis_kelamin === 'L') /images/male.png @else /images/female.png @endif @else {{asset('storage/'.$user->foto)}} @endif"
                                 class="img-fluid rounded-circle border border-3 border-primary shadow"
                                 alt="Foto Siswa"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h4 class="card-title mb-1">{{ $user->nama_lengkap }}</h4>
                        <p class="text-muted mb-2">
                            <i class="bi bi-person-badge me-1"></i>NISN: {{ $user->nisn }}
                        </p>
                        <p class="text-muted mb-0">
                            <i class="bi bi-upc me-1"></i>NIS: {{ $user->nis }}
                        </p>
                        <div class="mt-3">
                            <span class="badge bg-primary fs-6 px-3 py-2">{{ $user->jenis_kelamin }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 shadow-sm border-0 bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-event text-primary display-6 mb-2"></i>
                                <h6 class="card-title text-primary mb-1">Tahun Ajaran</h6>
                                <p class="mb-0 fw-bold">{{ $user->tahun_ajar->tahun_ajaran }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 shadow-sm border-0 bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-house-door text-success display-6 mb-2"></i>
                                <h6 class="card-title text-success mb-1">Kelas</h6>
                                <p class="mb-0 fw-bold">@if ($user->kelas) {{ $user->kelas->nama }} @else - @endif</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 shadow-sm border-0 bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-geo-alt text-info display-6 mb-2"></i>
                                <h6 class="card-title text-info mb-1">Sekolah Asal</h6>
                                <p class="mb-0 fw-bold">{{ $user->biodata->sekolah_asal }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 shadow-sm border-0 bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-heart-pulse text-danger display-6 mb-2"></i>
                                <h6 class="card-title text-danger mb-1">Golongan Darah</h6>
                                <p class="mb-0 fw-bold">{{ $user->biodata->goldar }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Information Cards -->
        <div class="row">
            <!-- Personal Information -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-primary text-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-person-lines-fill me-2"></i>Informasi Pribadi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">Tempat Lahir</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->tempat_lahir }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">Tanggal Lahir</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->tanggal_lahir }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">Alamat</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->alamat }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">Kecamatan</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->kecamatan }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">MPSN / MPN / MMT</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->mpsn_mpn_mmt ?: '-' }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">NIK / No. KK</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->nik_no_kk ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">RT / RW</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->rt_rw ?: '-' }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">Kode Pos</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->kode_pos ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">Tinggal Bersama</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->tinggal_bersama ?: '-' }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">Moda Kendaraan</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->moda_kendaraan ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">Tinggi Badan</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->tinggi }} cm</p>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">Berat Badan</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->berat }} kg</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">Bahasa</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->bahasa }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="info-item">
                                    <label class="form-label text-muted small mb-1">Agama</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->agama }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Family Information -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-success text-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-people me-2"></i>Informasi Keluarga
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Father's Information -->
                        <div class="mb-4">
                            <h6 class="text-success mb-3">
                                <i class="bi bi-gender-male me-1"></i>Data Ayah
                            </h6>
                            <div class="row">
                                <div class="col-sm-6 mb-2">
                                    <label class="form-label text-muted small mb-1">Nama</label>
                                    <p class="mb-0 fw-semibold">{{ $user->ayah->nama }}</p>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label class="form-label text-muted small mb-1">Pekerjaan</label>
                                    <p class="mb-0 fw-semibold">{{ $user->ayah->pekerjaan }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Mother's Information -->
                        <div class="mb-4">
                            <h6 class="text-info mb-3">
                                <i class="bi bi-gender-female me-1"></i>Data Ibu
                            </h6>
                            <div class="row">
                                <div class="col-sm-6 mb-2">
                                    <label class="form-label text-muted small mb-1">Nama</label>
                                    <p class="mb-0 fw-semibold">{{ $user->ibu->nama }}</p>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label class="form-label text-muted small mb-1">Pekerjaan</label>
                                    <p class="mb-0 fw-semibold">{{ $user->ibu->pekerjaan }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Siblings Information -->
                        <div>
                            <h6 class="text-warning mb-3">
                                <i class="bi bi-diagram-3 me-1"></i>Saudara
                            </h6>
                            <div class="row">
                                <div class="col-sm-4 mb-2">
                                    <label class="form-label text-muted small mb-1">Kandung</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->jlh_saudara }}</p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <label class="form-label text-muted small mb-1">Tiri</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->saudara_tiri }}</p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <label class="form-label text-muted small mb-1">Angkat</label>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->saudara_angkat }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-info-circle me-2"></i>Informasi Tambahan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <i class="bi bi-telephone text-info display-6 mb-2"></i>
                                    <h6 class="mb-1">Nomor HP</h6>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->nomor_hp ?: '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <i class="bi bi-compass text-primary display-6 mb-2"></i>
                                    <h6 class="mb-1">Jarak ke Sekolah</h6>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->jarak }} Km</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <i class="bi bi-flag text-success display-6 mb-2"></i>
                                    <h6 class="mb-1">Kewarganegaraan</h6>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->kewarganegaraan }}</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <i class="bi bi-chat-dots text-warning display-6 mb-2"></i>
                                    <h6 class="mb-1">Hobi</h6>
                                    <p class="mb-0 fw-semibold">{{ $user->biodata->hobi ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                        @if($user->biodata->penyakit)
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-warning border-0">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <strong>Riwayat Penyakit:</strong> {{ $user->biodata->penyakit }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .info-item {
            padding: 0.5rem;
            border-radius: 0.375rem;
            background-color: #f8f9fa;
        }
        .card {
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-2px);
        }

        /* Toast notification styles */
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 350px;
            max-width: 500px;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }
        .toast-notification.show {
            transform: translateX(0);
        }
        .toast-notification.hide {
            transform: translateX(100%);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('welcome-notification');

            // Show notification with slide-in animation
            setTimeout(function() {
                notification.classList.add('show');
            }, 100);

            // Hide notification after 3 seconds with slide-out animation
            setTimeout(function() {
                notification.classList.remove('show');
                notification.classList.add('hide');
                setTimeout(function() {
                    notification.style.display = 'none';
                }, 300); // Wait for slide transition
            }, 3000); // 3 seconds
        });
    </script>
@endsection
