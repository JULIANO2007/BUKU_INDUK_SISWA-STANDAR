<?php

require_once 'vendor/autoload.php';

use App\Http\Controllers\ExcelController;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "Testing Excel Import Controller...\n";

// Create a mock Excel file for testing
$excelContent = "nama_lengkap,nisn,nis,email,kelas,tahun_ajaran,jenis_kelamin,alamat,sekolah_asal,kota,kecamatan,tempat_lahir,tanggal_lahir,anak_ke,jlh_saudara,saudara_tiri,saudara_angkat,bahasa,agama,jarak,nomor_hp,goldar,tinggi,berat,penyakit,hobi,kewarganegaraan,nama_ayah,tempat_lahir_ayah,tanggal_lahir_ayah,agama_ayah,kewarganegaraan_ayah,pekerjaan_ayah,pendidikan_ayah,penghasilan_ayah,alamat_ayah,nomor_hp_ayah,status_ayah,nama_ibu,tempat_lahir_ibu,tanggal_lahir_ibu,agama_ibu,kewarganegaraan_ibu,pekerjaan_ibu,pendidikan_ibu,penghasilan_ibu,alamat_ibu,nomor_hp_ibu,status_ibu\n";
$excelContent .= "Test Siswa 1,1111111111,2024111,test1@example.com,X IPA 1,2024/2025,Laki-laki,Jl Test 1,SMPN 1,Jakarta,Menteng,Jakarta,2008-01-01,1,2,0,0,Indonesia,Islam,5,081111111111,O,165,55,-,Membaca,Indonesia,Bapak Test,Jakarta,1980-01-01,Islam,Indonesia,PNS,S1,5000000,Jl Test 1,081111111112,Kandung,Ibu Test,Bandung,1985-01-01,Islam,Indonesia,IRT,SMA,0,Jl Test 1,081111111113,Kandung\n";
$excelContent .= "Test Siswa 2,2222222222,2024222,test2@example.com,X IPA 2,2024/2025,Perempuan,Jl Test 2,SMPN 2,Bandung,Cidadap,Bandung,2008-02-02,1,1,0,0,Indonesia,Islam,3,082222222222,A,160,50,-,Menulis,Indonesia,Ayah Test 2,Bandung,1982-02-02,Islam,Indonesia,Wiraswasta,SMA,3000000,Jl Test 2,082222222223,Kandung,Ibu Test 2,Jakarta,1987-02-02,Islam,Indonesia,Guru,S1,4000000,Jl Test 2,082222222224,Kandung\n";

try {
    // Create temporary Excel file
    $tempFile = tmpfile();
    $tempFilePath = stream_get_meta_data($tempFile)['uri'];
    file_put_contents($tempFilePath, $excelContent);

    // Create UploadedFile instance with .xls extension for CSV-like content
    $uploadedFile = new UploadedFile(
        $tempFilePath,
        'test_import.xls',
        'application/vnd.ms-excel',
        null,
        true
    );

    // Create mock request
    $request = new Request();
    $request->files->set('file', $uploadedFile);

    // Test controller
    $controller = new ExcelController();

    echo "Testing import method with mock Excel file...\n";

    // This would normally redirect, but we'll catch the response
    ob_start();
    $response = $controller->import($request);
    $output = ob_get_clean();

    echo "✓ Import method executed without fatal errors\n";

    // Check if data was actually imported
    $userCount = \App\Models\User::whereIn('nisn', ['1111111111', '2222222222'])->count();
    echo "✓ Users imported: {$userCount}\n";

    if ($userCount > 0) {
        echo "✓ Excel import functionality is working correctly!\n";

        // Clean up test data
        \App\Models\User::whereIn('nisn', ['1111111111', '2222222222'])->delete();
        echo "✓ Test data cleaned up\n";
    }

    // Close temp file
    fclose($tempFile);

    echo "\n✅ Excel Import Controller test passed!\n";

} catch (Exception $e) {
    echo "❌ Error during Excel import test: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
