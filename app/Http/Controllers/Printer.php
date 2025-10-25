<?php

namespace App\Http\Controllers;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class Printer extends Controller
{
    public function daftar_siswa(){
        ini_set('max_execution_time', 300); // 5 minutes
        $res = User::where('status', 'siswa')->with('biodata')->get();
        $pdf = PDF::loadView('printout/daftar_siswa', ['res' => $res]);
        return $pdf->download('Daftar Siswa.pdf');
    }

    public function data_siswa(User $siswa){
        ini_set('max_execution_time', 300); // 5 minutes
        $pdf = PDF::loadView('printout/buku_induk_siswa', ['res' => $siswa]);
        return $pdf->download('Buku Induk '.$siswa->nama_lengkap.'.pdf');
    }

    public function buku_induk_zip(){
        ini_set('max_execution_time', 0); // Unlimited execution time
        $siswa = User::where('status', 'siswa')->with(['biodata', 'ayah', 'ibu', 'wali'])->get();

        $zipFileName = 'Buku_Induk_Siswa_' . date('Y-m-d_H-i-s') . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($siswa as $student) {
                // Generate PDF for each student
                $pdf = PDF::loadView('printout/buku_induk_siswa', ['res' => $student]);
                $pdfContent = $pdf->output();

                // Add PDF to zip
                $pdfFileName = 'Buku_Induk_' . str_replace(' ', '_', $student->nama_lengkap) . '.pdf';
                $zip->addFromString($pdfFileName, $pdfContent);

                // Add photo if exists (assuming photos are stored in public/images/students/)
                $photoPath = public_path('images/students/' . $student->id . '.jpg'); // Adjust extension as needed
                if (file_exists($photoPath)) {
                    $zip->addFile($photoPath, 'Foto_' . str_replace(' ', '_', $student->nama_lengkap) . '.jpg');
                }
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
