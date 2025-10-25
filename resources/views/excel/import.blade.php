@extends('layouts.base')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Import Data Siswa</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('excel.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Pilih File Excel</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".xlsx,.xls">
                            @error('file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Import Data</button>
                            <a href="{{ route('excel.export') }}" class="btn btn-success">Export Data Siswa</a>
                            <a href="{{ route('excel.template') }}" class="btn btn-info">Download Template Kosong</a>
                        </div>
                    </form>

                    <div class="mt-4">
                        <h4>Petunjuk Import Data Siswa:</h4>
                        <ol>
                            <li><strong>Download Template:</strong> Klik tombol "Export Data Siswa" untuk mendapatkan template dengan data contoh, atau "Download Template Kosong" untuk template kosong</li>
                            <li>Isi data siswa sesuai dengan kolom-kolom yang tersedia</li>
                            <li>
                                <strong>Kolom Wajib Diisi:</strong>
                                <ul>
                                    <li><strong>nama_lengkap</strong> - Nama lengkap siswa</li>
                                    <li><strong>nisn</strong> - Nomor Induk Siswa Nasional (10 digit)</li>
                                    <li><strong>nis</strong> - Nomor Induk Siswa</li>
                                    <li><strong>email</strong> - Alamat email siswa</li>
                                    <li><strong>kelas</strong> - Nama kelas (contoh: X IPA 1)</li>
                                    <li><strong>tahun_ajaran</strong> - Tahun ajaran (contoh: 2024/2025)</li>
                                    <li><strong>jenis_kelamin</strong> - Laki-laki atau Perempuan</li>
                                </ul>
                            </li>
                            <li>
                                <strong>Kolom Opsional (Biodata Lengkap):</strong>
                                <ul>
                                    <li>alamat, sekolah_asal, kota, kecamatan</li>
                                    <li>tempat_lahir, tanggal_lahir (format: YYYY-MM-DD)</li>
                                    <li>anak_ke, jlh_saudara, saudara_tiri, saudara_angkat</li>
                                    <li>bahasa, agama, jarak (km), nomor_hp</li>
                                    <li>goldar, tinggi (cm), berat (kg), penyakit, hobi</li>
                                    <li>kewarganegaraan</li>
                                </ul>
                            </li>
                            <li>
                                <strong>Kolom Data Orang Tua (Opsional):</strong>
                                <ul>
                                    <li><strong>Ayah:</strong> nama_ayah, tempat_lahir_ayah, tanggal_lahir_ayah, agama_ayah, kewarganegaraan_ayah, pekerjaan_ayah, pendidikan_ayah, penghasilan_ayah, alamat_ayah, nomor_hp_ayah, status_ayah</li>
                                    <li><strong>Ibu:</strong> nama_ibu, tempat_lahir_ibu, tanggal_lahir_ibu, agama_ibu, kewarganegaraan_ibu, pekerjaan_ibu, pendidikan_ibu, penghasilan_ibu, alamat_ibu, nomor_hp_ibu, status_ibu</li>
                                </ul>
                            </li>
                            <li>Pilih file Excel (.xlsx atau .xls) dan klik tombol "Import Data"</li>
                            <li>Sistem akan membuat atau memperbarui akun siswa dengan password default = NISN</li>
                            <li><strong>Catatan:</strong> Import dapat digunakan untuk menambah siswa baru atau memperbarui data siswa yang sudah ada</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
