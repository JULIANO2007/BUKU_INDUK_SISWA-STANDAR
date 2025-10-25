@extends('layouts.base')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="card shadow-sm border-0 bg-white rounded-3">
            <div class="card-header bg-white border-0 py-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <h3 class="fw-bold text-dark mb-0">Daftar Siswa</h3>
                    <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                        <form action="/admin/siswa" class="flex-grow-1 flex-md-grow-0">
                            <div class="input-group">
                                <input type="text" class="form-control border-end-0" placeholder="Cari siswa..." name="cari" value="{{ request('cari')}}">
                                <button class="btn btn-outline-secondary border-start-0" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                        <a href="/excel/import" class="btn btn-success d-flex align-items-center gap-2">
                            <i class="bi bi-upload"></i>
                            <span class="d-none d-sm-inline">Import Excel</span>
                        </a>
                        <a href="/admin/print" class="btn btn-warning d-flex align-items-center gap-2">
                            <i class="bi bi-printer"></i>
                            <span class="d-none d-sm-inline">Cetak</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                @if($res->count())
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-hover mb-0" style="width: 100%; min-width: 800px;">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold py-3 px-4" style="width: 5%;">#</th>
                                    <th class="border-0 fw-semibold py-3" style="width: 25%;">Nama Siswa</th>
                                    <th class="border-0 fw-semibold py-3" style="width: 15%;">NISN</th>
                                    <th class="border-0 fw-semibold py-3" style="width: 20%;">Data Ayah</th>
                                    <th class="border-0 fw-semibold py-3" style="width: 20%;">Data Ibu</th>
                                    <th class="border-0 fw-semibold py-3 px-4 text-end" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($res as $item)
                                    <tr>
                                        <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                        <td class="py-3">
                                            <div style="word-wrap: break-word; max-width: 200px;">{{ $item->nama_lengkap }}</div>
                                        </td>
                                        <td class="py-3">{{ $item->nisn }}</td>
                                        <td class="py-3">
                                            <a href="/admin/ayah/{{$item->ayah->uri}}" class="text-decoration-none text-primary" style="word-wrap: break-word; max-width: 150px; display: inline-block;">{{ $item->ayah->nama }}</a>
                                        </td>
                                        <td class="py-3">
                                            <a href="/admin/ibu/{{$item->ibu->uri}}" class="text-decoration-none text-primary" style="word-wrap: break-word; max-width: 150px; display: inline-block;">{{ $item->ibu->nama }}</a>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="d-flex justify-content-center gap-2">
                                                <form action="/admin/siswa/{{$item->nisn}}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Anda yakin akan menghapus siswa ini?')" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                                <a href="/admin/siswa/{{$item->nisn}}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/siswa/{{$item->nisn}}/edit" class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white border-0 py-3 px-4">
                        <div class="d-flex justify-content-center">
                            {{ $res->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <img src="/images/empty.jpg" alt="Data kosong" class="img-fluid mb-4" style="max-width: 200px;">
                        <h4 class="text-muted fw-semibold mb-3">Data Siswa Tidak Ditemukan</h4>
                        <a href="/admin/siswa/create" class="btn btn-primary btn-lg d-inline-flex align-items-center gap-2">
                            <i class="bi bi-plus-circle"></i>
                            Tambah Siswa
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
