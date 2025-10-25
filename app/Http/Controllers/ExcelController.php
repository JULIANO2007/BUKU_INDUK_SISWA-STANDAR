<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class ExcelController extends Controller
{
    public function importForm()
    {
        return view('excel.import', [
            'title' => 'Import Data Siswa'
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            $import = new StudentsImport();
            Excel::import($import, $request->file('file'));
            $count = $import->getRowCount();
            return redirect()->back()->with('success', 'Data berhasil diimport! (' . $count . ' siswa)');
        } catch (\Exception $e) {
            \Log::error('Import failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function export()
    {
        try {
            return Excel::download(new StudentsExport(true), 'data-siswa-'.date('Y-m-d').'.xlsx');
        } catch (\Exception $e) {
            return redirect()->route('excel.import.form')->with('error', 'Terjadi kesalahan saat export: ' . $e->getMessage());
        }
    }

    public function template()
    {
        try {
            return Excel::download(new StudentsExport(false), 'template-import-siswa-'.date('Y-m-d').'.xlsx');
        } catch (\Exception $e) {
            return redirect()->route('excel.import.form')->with('error', 'Terjadi kesalahan saat download template: ' . $e->getMessage());
        }
    }
}
