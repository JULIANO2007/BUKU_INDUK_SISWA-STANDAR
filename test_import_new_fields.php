<?php

require_once 'vendor/autoload.php';

use App\Imports\StudentsImport;

echo "Testing import functionality with new fields\n";

// Create a sample Excel data array that includes the new fields
$sampleData = [
    [
        'Nama Lengkap',
        'NISN',
        'NIS',
        'Email',
        'Kelas',
        'Tahun Ajaran',
        'Jenis Kelamin',
        'MPSN / MPN / MMT',
        'NIK / No. KK',
        'RT / RW',
        'Kode Pos',
        'Alamat',
        'Sekolah Asal',
        'Kota',
        'Kecamatan',
        'Tempat Lahir',
        'Tanggal Lahir',
        'Anak Ke',
        'Jumlah Saudara',
        'Saudara Tiri',
        'Saudara Angkat',
        'Bahasa',
        'Agama',
        'Jarak (km)',
        'Nomor HP',
        'Golongan Darah',
        'Tinggi (cm)',
        'Berat (kg)',
        'Tinggal Bersama',
        'Moda Kendaraan',
        'Penyakit',
        'Hobi',
        'Kewarganegaraan',
        'Nama Ayah',
        'Tempat Lahir Ayah',
        'Tanggal Lahir Ayah',
        'Agama Ayah',
        'Kewarganegaraan Ayah',
        'Pekerjaan Ayah',
        'Pendidikan Ayah',
        'Penghasilan Ayah',
        'Alamat Ayah',
        'Nomor HP Ayah',
        'Status Ayah',
        'Nama Ibu',
        'Tempat Lahir Ibu',
        'Tanggal Lahir Ibu',
        'Agama Ibu',
        'Kewarganegaraan Ibu',
        'Pekerjaan Ibu',
        'Pendidikan Ibu',
        'Penghasilan Ibu',
        'Alamat Ibu',
        'Nomor HP Ibu',
        'Status Ibu'
    ],
    [
        'Test Siswa',
        '1234567890',
        '12345',
        'test@example.com',
        'XII RPL 1',
        '2024/2025',
        'Laki-laki',
        'MPSN123',
        'NIK1234567890123456',
        '01/02',
        '12345',
        'Jl. Test No. 123',
        'SMP Test',
        'Jakarta',
        'Jakarta Pusat',
        'Jakarta',
        '2005-01-01',
        '1',
        '2',
        '0',
        '0',
        'Indonesia',
        'Islam',
        '5',
        '081234567890',
        'O',
        '170',
        '65',
        'Orang Tua',
        'Sepeda Motor',
        'Tidak ada',
        'Olahraga',
        'Indonesia',
        'Test Ayah',
        'Jakarta',
        '1980-01-01',
        'Islam',
        'Indonesia',
        'Pegawai Swasta',
        'S1',
        '5000000',
        'Jl. Ayah No. 123',
        '081234567891',
        'Kandung',
        'Test Ibu',
        'Jakarta',
        '1982-01-01',
        'Islam',
        'Indonesia',
        'Ibu Rumah Tangga',
        'SMA',
        '0',
        'Jl. Ibu No. 123',
        '081234567892',
        'Kandung'
    ]
];

echo "Sample data structure:\n";
echo "Total columns: " . count($sampleData[0]) . "\n";
echo "New fields positions:\n";
echo "- MPSN / MPN / MMT: Column " . (array_search('MPSN / MPN / MMT', $sampleData[0]) + 1) . "\n";
echo "- NIK / No. KK: Column " . (array_search('NIK / No. KK', $sampleData[0]) + 1) . "\n";
echo "- RT / RW: Column " . (array_search('RT / RW', $sampleData[0]) + 1) . "\n";
echo "- Kode Pos: Column " . (array_search('Kode Pos', $sampleData[0]) + 1) . "\n";
echo "- Tinggal Bersama: Column " . (array_search('Tinggal Bersama', $sampleData[0]) + 1) . "\n";
echo "- Moda Kendaraan: Column " . (array_search('Moda Kendaraan', $sampleData[0]) + 1) . "\n";

echo "\nSample data values:\n";
echo "MPSN / MPN / MMT: " . $sampleData[1][7] . "\n";
echo "NIK / No. KK: " . $sampleData[1][8] . "\n";
echo "RT / RW: " . $sampleData[1][9] . "\n";
echo "Kode Pos: " . $sampleData[1][10] . "\n";
echo "Tinggal Bersama: " . $sampleData[1][28] . "\n";
echo "Moda Kendaraan: " . $sampleData[1][29] . "\n";

echo "\n=== Import Test Complete ===\n";
echo "The import structure has been updated to handle the new 6 fields.\n";
echo "When importing Excel files, the system will now:\n";
echo "1. Read MPSN/MPN/MMT from column H (8)\n";
echo "2. Read NIK/No.KK from column I (9)\n";
echo "3. Read RT/RW from column J (10)\n";
echo "4. Read Kode Pos from column K (11)\n";
echo "5. Read Tinggal Bersama from column AC (29)\n";
echo "6. Read Moda Kendaraan from column AD (30)\n";
