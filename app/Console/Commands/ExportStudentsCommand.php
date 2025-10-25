<?php

namespace App\Console\Commands;

use App\Exports\StudentsExport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportStudentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'excel:export-students {--file=students_template.xlsx : Nama file output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export template Excel untuk import data siswa lengkap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = $this->option('file');

        $this->info('Memulai export template Excel siswa...');

        try {
            Excel::store(new StudentsExport(), $filename, 'public');

            $this->info("✅ Template Excel berhasil dibuat: storage/app/public/{$filename}");
            $this->info('Template ini berisi semua kolom yang diperlukan untuk import data siswa lengkap.');
            $this->info('Anda dapat mendownload file ini dari: /storage/' . $filename);

            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Gagal membuat template Excel: ' . $e->getMessage());
            return 1;
        }
    }
}
