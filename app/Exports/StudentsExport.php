<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    private $exportData;

    public function __construct($exportData = false)
    {
        $this->exportData = $exportData;
    }

    public function collection()
    {
        if ($this->exportData) {
            // Export data siswa yang ada
            return User::where('status', 'siswa')->with(['biodata', 'ayah', 'ibu', 'kelas', 'tahun_ajar'])->get();
        } else {
            // Return empty collection untuk template kosong (hanya header)
            return collect([]);
        }
    }

    public function headings(): array
    {
        return [
            // Data Wajib
            'Nama Lengkap',
            'NISN',
            'NIS',
            'Email',
            'Kelas',
            'Tahun Ajaran',
            'Jenis Kelamin',

            // Biodata Lengkap
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

            // Data Ayah
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

            // Data Ibu
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
            'Status Ibu',
        ];
    }

    public function title(): string
    {
        return 'Data Siswa Lengkap';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Nama Lengkap
            'B' => 15, // NISN
            'C' => 15, // NIS
            'D' => 30, // Email
            'E' => 15, // Kelas
            'F' => 15, // Tahun Ajaran
            'G' => 15, // Jenis Kelamin
            'H' => 20, // MPSN / MPN / MMT
            'I' => 20, // NIK / No. KK
            'J' => 10, // RT / RW
            'K' => 10, // Kode Pos
            'L' => 30, // Alamat
            'M' => 25, // Sekolah Asal
            'N' => 15, // Kota
            'O' => 15, // Kecamatan
            'P' => 20, // Tempat Lahir
            'Q' => 15, // Tanggal Lahir
            'R' => 10, // Anak Ke
            'S' => 15, // Jumlah Saudara
            'T' => 15, // Saudara Tiri
            'U' => 15, // Saudara Angkat
            'V' => 15, // Bahasa
            'W' => 15, // Agama
            'X' => 12, // Jarak
            'Y' => 15, // Nomor HP
            'Z' => 15, // Golongan Darah
            'AA' => 12, // Tinggi
            'AB' => 12, // Berat
            'AC' => 15, // Tinggal Bersama
            'AD' => 15, // Moda Kendaraan
            'AE' => 20, // Penyakit
            'AF' => 20, // Hobi
            'AG' => 15, // Kewarganegaraan
            'AH' => 20, // Nama Ayah
            'AI' => 20, // Tempat Lahir Ayah
            'AJ' => 18, // Tanggal Lahir Ayah
            'AK' => 15, // Agama Ayah
            'AL' => 18, // Kewarganegaraan Ayah
            'AM' => 20, // Pekerjaan Ayah
            'AN' => 20, // Pendidikan Ayah
            'AO' => 15, // Penghasilan Ayah
            'AP' => 30, // Alamat Ayah
            'AQ' => 15, // Nomor HP Ayah
            'AR' => 15, // Status Ayah
            'AS' => 20, // Nama Ibu
            'AT' => 20, // Tempat Lahir Ibu
            'AU' => 18, // Tanggal Lahir Ibu
            'AV' => 15, // Agama Ibu
            'AW' => 18, // Kewarganegaraan Ibu
            'AX' => 20, // Pekerjaan Ibu
            'AY' => 20, // Pendidikan Ibu
            'AZ' => 15, // Penghasilan Ibu
            'BA' => 30, // Alamat Ibu
            'BB' => 15, // Nomor HP Ibu
            'BC' => 15, // Status Ibu
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:BC1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2E75B6'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Style untuk data
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 1) {
            $sheet->getStyle('A2:BC' . $lastRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'B8CCE4'],
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
            ]);

            // Alternate row colors
            for ($row = 2; $row <= $lastRow; $row++) {
                if ($row % 2 == 0) {
                    $sheet->getStyle('A' . $row . ':BC' . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F2F2F2'],
                        ],
                    ]);
                }
            }
        }

        // Auto wrap text untuk kolom yang panjang
        $sheet->getStyle('A:BC')->getAlignment()->setWrapText(true);

        // Set row height untuk header
        $sheet->getRowDimension(1)->setRowHeight(40);

        // Set default row height untuk data dengan auto height
        for ($row = 2; $row <= $lastRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1); // Auto height
        }

        return [];
    }



    public function map($user): array
    {
        if (!$this->exportData) {
            // Template kosong tidak perlu mapping data
            return [];
        }

        return [
            $user->nama_lengkap,
            $user->nisn,
            $user->nis,
            $user->email,
            $user->kelas ? $user->kelas->nama : '',
            $user->tahun_ajar ? $user->tahun_ajar->tahun_ajaran : '',
            $user->jenis_kelamin,

            // Biodata
            $user->biodata ? $user->biodata->mpsn_mpn_mmt : '',
            $user->biodata ? $user->biodata->nik_no_kk : '',
            $user->biodata ? $user->biodata->rt_rw : '',
            $user->biodata ? $user->biodata->kode_pos : '',
            $user->biodata ? $user->biodata->alamat : '',
            $user->biodata ? $user->biodata->sekolah_asal : '',
            $user->biodata ? $user->biodata->kota : '',
            $user->biodata ? $user->biodata->kecamatan : '',
            $user->biodata ? $user->biodata->tempat_lahir : '',
            $user->biodata ? $user->biodata->tanggal_lahir : '',
            $user->biodata ? $user->biodata->anak_ke : '',
            $user->biodata ? $user->biodata->jlh_saudara : '',
            $user->biodata ? $user->biodata->saudara_tiri : '',
            $user->biodata ? $user->biodata->saudara_angkat : '',
            $user->biodata ? $user->biodata->bahasa : '',
            $user->biodata ? $user->biodata->agama : '',
            $user->biodata ? $user->biodata->jarak : '',
            $user->biodata ? $user->biodata->nomor_hp : '',
            $user->biodata ? $user->biodata->goldar : '',
            $user->biodata ? $user->biodata->tinggi : '',
            $user->biodata ? $user->biodata->berat : '',
            $user->biodata ? $user->biodata->tinggal_bersama : '',
            $user->biodata ? $user->biodata->moda_kendaraan : '',
            $user->biodata ? $user->biodata->penyakit : '',
            $user->biodata ? $user->biodata->hobi : '',
            $user->biodata ? $user->biodata->kewarganegaraan : '',

            // Data Ayah
            $user->ayah ? $user->ayah->nama : '',
            $user->ayah ? $user->ayah->tempat_lahir : '',
            $user->ayah ? $user->ayah->tanggal_lahir : '',
            $user->ayah ? $user->ayah->agama : '',
            $user->ayah ? $user->ayah->kewarganegaraan : '',
            $user->ayah ? $user->ayah->pekerjaan : '',
            $user->ayah ? $user->ayah->pendidikan : '',
            $user->ayah ? $user->ayah->penghasilan : '',
            $user->ayah ? $user->ayah->alamat : '',
            $user->ayah ? $user->ayah->nomor_hp : '',
            $user->ayah ? $user->ayah->status : '',

            // Data Ibu
            $user->ibu ? $user->ibu->nama : '',
            $user->ibu ? $user->ibu->tempat_lahir : '',
            $user->ibu ? $user->ibu->tanggal_lahir : '',
            $user->ibu ? $user->ibu->agama : '',
            $user->ibu ? $user->ibu->kewarganegaraan : '',
            $user->ibu ? $user->ibu->pekerjaan : '',
            $user->ibu ? $user->ibu->pendidikan : '',
            $user->ibu ? $user->ibu->penghasilan : '',
            $user->ibu ? $user->ibu->alamat : '',
            $user->ibu ? $user->ibu->nomor_hp : '',
            $user->ibu ? $user->ibu->status : '',
        ];
    }
}
