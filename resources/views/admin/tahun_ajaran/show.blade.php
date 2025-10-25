@extends('layouts.base')

@section('content')
    <div class="container card shadow mt-3 mb-3 p-3 w-100">
      <div class="row mb-3">
        <h3 class="text-center text-uppercase">Detail Tahun Ajaran</h3>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h5>Informasi Tahun Ajaran</h5>
            </div>
            <div class="card-body">
              <p><strong>Tahun Ajaran:</strong> {{ $tahun->tahun_ajaran }}</p>
              <p><strong>Status:</strong>
                @if ($tahun->status === 'aktif')
                  <span class="badge bg-success">{{ $tahun->status }}</span>
                @else
                  <span class="badge bg-secondary">{{ $tahun->status }}</span>
                @endif
              </p>
              <p><strong>Dibuat pada:</strong> {{ $tahun->created_at->format('d M Y H:i') }}</p>
              <p><strong>Diperbarui pada:</strong> {{ $tahun->updated_at->format('d M Y H:i') }}</p>
            </div>
            <div class="card-footer">
              <a href="/admin/tahun" class="btn btn-secondary">Kembali</a>
              <a href="/admin/tahun/{{ $tahun->id }}/edit" class="btn btn-warning ms-2">Ubah</a>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
