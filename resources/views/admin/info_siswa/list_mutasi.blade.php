@extends('layouts.base')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="card shadow-sm border-0 bg-white rounded-3">
            <div class="card-header bg-white border-0 py-4">
                <h3 class="fw-bold text-dark mb-0 text-center text-uppercase">{{ $title }}</h3>
            </div>
            <div class="card-body p-0">
                @if($res->count())
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-hover mb-0" style="width: 100%; min-width: 800px;">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold py-3 px-4" style="width: 25%;">Nama Siswa</th>
                                    <th class="border-0 fw-semibold py-3" style="width: 25%;">Tujuan Sekolah</th>
                                    <th class="border-0 fw-semibold py-3" style="width: 25%;">Alasan Kepindahan</th>
                                    <th class="border-0 fw-semibold py-3" style="width: 15%;">Tanggal</th>
                                    <th class="border-0 fw-semibold py-3 px-4 text-end" style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($res as $item)
                                    @foreach ($siswa as $key)
                                        @if ($item->user_id === $key->id)
                                            <tr>
                                                <td class="py-3 px-4">
                                                    <div style="word-wrap: break-word; max-width: 200px;">{{ $key->nama_lengkap }}</div>
                                                </td>
                                                <td class="py-3">
                                                    <div style="word-wrap: break-word; max-width: 200px;">{{ $item->tujuan }}</div>
                                                </td>
                                                <td class="py-3">
                                                    <div style="word-wrap: break-word; max-width: 200px;">{{ $item->alasan }}</div>
                                                </td>
                                                <td class="py-3">{{ $item->tanggal_pindah }}</td>
                                                <td class="py-3 px-4">
                                                    <div class="d-flex justify-content-end gap-1 flex-wrap">
                                                        <a href="/admin/mutasi/{{$key->nisn}}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form action="/admin/mutasi/{{$item->id}}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data mutasi ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <img src="/images/empty.jpg" alt="Data kosong" class="img-fluid mb-4" style="max-width: 200px;">
                        <h4 class="text-muted fw-semibold mb-3">Belum Ada Data Mutasi</h4>
                        <p class="text-muted">Data mutasi siswa akan muncul di sini setelah ada siswa yang melakukan perpindahan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
