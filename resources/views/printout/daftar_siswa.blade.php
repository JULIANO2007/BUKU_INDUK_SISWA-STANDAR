<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Daftar Siswa</title>
  <style>
    @page {
      size: A4;
      margin: 2cm;
    }
    body {
      font-family: 'Times New Roman', serif;
      font-size: 12pt;
      line-height: 1.4;
      color: #000;
    }
    .header {
      text-align: center;
      margin-bottom: 20px;
    }
    .header img {
      max-width: 100px;
      height: auto;
      margin-bottom: 10px;
    }
    .header h1 {
      margin: 0;
      font-size: 18pt;
      font-weight: bold;
    }
    .header p {
      margin: 5px 0;
      font-size: 10pt;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #000;
      padding: 10px;
      text-align: left;
      vertical-align: top;
    }
    th {
      background-color: #f0f0f0;
      font-weight: bold;
      text-align: center;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 10pt;
      border-top: 1px solid #000;
      padding-top: 10px;
    }
    .no-data {
      text-align: center;
      font-style: italic;
      color: #666;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>Daftar Siswa</h1>
    <p>Tahun Ajaran: {{ now()->year }} / {{ now()->year + 1 }}</p>
    <p>Tanggal Cetak: {{ now()->format('d F Y') }}</p>
  </div>

  @if ($res->count() > 0)
    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama Lengkap</th>
          <th>NISN</th>
          <th>NIS</th>
          <th>Alamat</th>
          <th>Nomor HP</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($res as $item)
          <tr>
            <td style="text-align: center;">{{ $loop->iteration }}</td>
            <td>{{ $item->nama_lengkap }}</td>
            <td style="text-align: center;">{{ $item->nisn }}</td>
            <td style="text-align: center;">{{ $item->nis }}</td>
            <td>{{ $item->biodata->alamat ?? 'Tidak tersedia' }}</td>
            <td style="text-align: center;">{{ $item->biodata->nomor_hp ?? 'Tidak tersedia' }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="no-data">Tidak ada data siswa yang tersedia.</p>
  @endif

</body>
</html>
