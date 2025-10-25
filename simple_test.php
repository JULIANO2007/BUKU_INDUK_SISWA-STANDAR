<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "Testing StudentsImport directly...\n";

try {
    // Create a simple array like what Excel would provide
    $row = [
        'nama_lengkap' => 'Test Siswa 1',
        'nisn' => '1111111111',
        'nis' => '2024111',
        'email' => 'test1@example.com',
        'kelas' => 'X IPA 1',
        'tahun_ajaran' => '2024/2025',
        'jenis_kelamin' => 'Laki-laki',
        'alamat' => 'Jl Test 1',
        'sekolah_asal' => 'SMPN 1',
        'kota' => 'Jakarta',
        'kecamatan' => 'Menteng',
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => '2008-01-01',
        'anak_ke' => 1,
        'jlh_saudara' => 2,
        'saudara_tiri' => 0,
        'saudara_angkat' => 0,
        'bahasa' => 'Indonesia',
        'agama' => 'Islam',
        'jarak' => 5,
        'nomor_hp' => '081111111111',
        'goldar' => 'O',
        'tinggi' => 165,
        'berat' => 55,
        'penyakit' => '-',
        'hobi' => 'Membaca',
        'kewarganegaraan' => 'Indonesia',
        'nama_ayah' => 'Bapak Test',
        'tempat_lahir_ayah' => 'Jakarta',
        'tanggal_lahir_ayah' => '1980-01-01',
        'agama_ayah' => 'Islam',
        'kewarganegaraan_ayah' => 'Indonesia',
        'pekerjaan_ayah' => 'PNS',
        'pendidikan_ayah' => 'S1',
        'penghasilan_ayah' => 5000000,
        'alamat_ayah' => 'Jl Test 1',
        'nomor_hp_ayah' => '081111111112',
        'status_ayah' => 'Kandung',
        'nama_ibu' => 'Ibu Test',
        'tempat_lahir_ibu' => 'Bandung',
        'tanggal_lahir_ibu' => '1985-01-01',
        'agama_ibu' => 'Islam',
        'kewarganegaraan_ibu' => 'Indonesia',
        'pekerjaan_ibu' => 'IRT',
        'pendidikan_ibu' => 'SMA',
        'penghasilan_ibu' => 0,
        'alamat_ibu' => 'Jl Test 1',
        'nomor_hp_ibu' => '081111111113',
        'status_ibu' => 'Kandung'
    ];

    echo "Testing model() method directly...\n";

    $import = new \App\Imports\StudentsImport();
    $result = $import->model($row);

    echo "Model method returned: " . ($result ? 'User object' : 'null') . "\n";
    echo "Row count: " . $import->getRowCount() . "\n";

    // Check database
    $users = \App\Models\User::where('nisn', '1111111111')->get();
    echo "Users in database: " . $users->count() . "\n";

    if ($users->count() > 0) {
        echo "User details:\n";
        foreach ($users as $user) {
            echo "  - ID: {$user->id}, Name: {$user->nama_lengkap}, NISN: {$user->nisn}\n";
        }
    }

    // Clean up
    foreach ($users as $user) {
        $user->delete();
    }

    echo "✅ Test completed\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
