<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Biodata;
use App\Models\Dad;
use App\Models\Mom;
use App\Models\Group;
use App\Models\Year;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentsImport implements ToModel, WithValidation, SkipsOnError, SkipsOnFailure
{
    private $rowCount = 0;

    /**
     * Convert Excel date to Y-m-d format
     * Handles both Excel serial dates (numbers) and string dates
     */
    private function convertExcelDate($value)
    {
        if (empty($value)) {
            return null;
        }

        $value = trim($value);

        // If it's numeric, treat as Excel serial date
        if (is_numeric($value)) {
            try {
                $dateTime = Date::excelToDateTimeObject($value);
                return $dateTime->format('Y-m-d');
            } catch (\Exception $e) {
                \Log::warning('Failed to convert Excel date: ' . $value . ' - ' . $e->getMessage());
                return null;
            }
        }

        // If it's already a string date, try to parse it
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            \Log::warning('Failed to parse date string: ' . $value . ' - ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Extract numeric value from string (removes units like 'kg', 'cm', etc.)
     * Returns null if no numeric value found
     */
    private function extractNumeric($value)
    {
        if (empty($value)) {
            return null;
        }

        $value = trim($value);

        // Use regex to extract first numeric value (including decimals)
        if (preg_match('/(\d+(?:\.\d+)?)/', $value, $matches)) {
            return (float) $matches[1];
        }

        return null;
    }

    public function model(array $row)
    {
        // Debug: Log the row data
        \Log::info('Processing row:', $row);

        // Skip if row is empty or doesn't have enough columns
        if (count($row) < 7 || empty($row[0]) || empty($row[1])) {
            \Log::warning('Skipping empty row or incomplete row');
            return null;
        }

        // Skip header row if it contains column names (check first column)
        if (strtolower(trim($row[0])) === 'nama lengkap' || strtolower(trim($row[1])) === 'nisn') {
            \Log::warning('Skipping header row');
            return null;
        }

        try {
            // Cari atau buat Year berdasarkan tahun_ajaran (index 5)
            $year = Year::firstOrCreate([
                'tahun_ajaran' => trim($row[5])
            ]);

            // Cari atau buat Group berdasarkan kelas (index 4)
            $group = Group::firstOrCreate(
                ['nama' => trim($row[4])],
                ['uri' => Str::slug(trim($row[4]))]
            );

            // Buat atau update User
            $user = User::updateOrCreate(
                ['nisn' => trim($row[1])],
                [
                    'year_id' => $year->id,
                    'group_id' => $group->id,
                    'nama_lengkap' => trim($row[0]),
                    'nis' => trim($row[2]),
                    'status' => 'siswa',
                    'email' => trim($row[3]),
                    'password' => Hash::make(trim($row[1])), // Password default menggunakan NISN
                    'jenis_kelamin' => trim($row[6]),
                ]
            );

            \Log::info('User created:', ['id' => $user->id, 'nama' => $user->nama_lengkap]);

            // Buat atau update Biodata dengan user_id yang benar
            $biodata = Biodata::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'uri' => Str::slug(trim($row[1]) . '-biodata-' . $user->id),
                    'mpsn_mpn_mmt' => isset($row[7]) ? trim($row[7]) : null,
                    'nik_no_kk' => isset($row[8]) ? trim($row[8]) : null,
                    'rt_rw' => isset($row[9]) ? trim($row[9]) : null,
                    'kode_pos' => isset($row[10]) ? trim($row[10]) : null,
                    'alamat' => isset($row[11]) ? trim($row[11]) : null,
                    'sekolah_asal' => isset($row[12]) ? trim($row[12]) : null,
                    'kota' => isset($row[13]) ? trim($row[13]) : null,
                    'kecamatan' => isset($row[14]) ? trim($row[14]) : null,
                    'tempat_lahir' => isset($row[15]) ? trim($row[15]) : null,
                    'tanggal_lahir' => $this->convertExcelDate($row[16] ?? null),
                    'anak_ke' => isset($row[17]) ? trim($row[17]) : null,
                    'jlh_saudara' => isset($row[18]) ? trim($row[18]) : null,
                    'saudara_tiri' => isset($row[19]) ? trim($row[19]) : null,
                    'saudara_angkat' => isset($row[20]) ? trim($row[20]) : null,
                    'bahasa' => isset($row[21]) ? trim($row[21]) : null,
                    'agama' => isset($row[22]) ? trim($row[22]) : null,
                    'jarak' => isset($row[23]) ? $this->extractNumeric($row[23]) : null,
                    'nomor_hp' => isset($row[24]) ? trim($row[24]) : null,
                    'goldar' => isset($row[25]) ? trim($row[25]) : null,
                    'tinggi' => isset($row[26]) ? $this->extractNumeric($row[26]) : null,
                    'berat' => isset($row[27]) ? $this->extractNumeric($row[27]) : null,
                    'tinggal_bersama' => isset($row[28]) ? trim($row[28]) : null,
                    'moda_kendaraan' => isset($row[29]) ? trim($row[29]) : null,
                    'penyakit' => isset($row[30]) ? trim($row[30]) : null,
                    'hobi' => isset($row[31]) ? trim($row[31]) : null,
                    'kewarganegaraan' => isset($row[32]) ? trim($row[32]) : null,
                ]
            );

            // Buat atau update Dad data dengan user_id yang benar
            if (isset($row[33]) && !empty(trim($row[33]))) {
                Dad::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'uri' => Str::slug(trim($row[33]) . '-ayah-' . trim($row[1]) . '-' . $user->id),
                        'nama' => trim($row[33]),
                        'tempat_lahir' => isset($row[34]) ? trim($row[34]) : null,
                        'tanggal_lahir' => $this->convertExcelDate($row[35] ?? null),
                        'agama' => isset($row[36]) ? trim($row[36]) : null,
                        'kewarganegaraan' => isset($row[37]) ? trim($row[37]) : null,
                        'pekerjaan' => isset($row[38]) ? trim($row[38]) : null,
                        'pendidikan' => isset($row[39]) ? trim($row[39]) : null,
                        'penghasilan' => isset($row[40]) ? $this->extractNumeric($row[40]) : null,
                        'alamat' => isset($row[41]) ? trim($row[41]) : null,
                        'nomor_hp' => isset($row[42]) ? trim($row[42]) : null,
                        'status' => isset($row[43]) ? trim($row[43]) : null,
                    ]
                );
            }

            // Buat atau update Mom data dengan user_id yang benar
            if (isset($row[44]) && !empty(trim($row[44]))) {
                Mom::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'uri' => Str::slug(trim($row[44]) . '-ibu-' . trim($row[1]) . '-' . $user->id),
                        'nama' => trim($row[44]),
                        'tempat_lahir' => isset($row[45]) ? trim($row[45]) : null,
                        'tanggal_lahir' => $this->convertExcelDate($row[46] ?? null),
                        'agama' => isset($row[47]) ? trim($row[47]) : null,
                        'kewarganegaraan' => isset($row[48]) ? trim($row[48]) : null,
                        'pekerjaan' => isset($row[49]) ? trim($row[49]) : null,
                        'pendidikan' => isset($row[50]) ? trim($row[50]) : null,
                        'penghasilan' => isset($row[51]) ? $this->extractNumeric($row[51]) : null,
                        'alamat' => isset($row[52]) ? trim($row[52]) : null,
                        'nomor_hp' => isset($row[53]) ? trim($row[53]) : null,
                        'status' => isset($row[54]) ? trim($row[54]) : null,
                    ]
                );
            }

            $this->rowCount++;
            \Log::info('Row processed successfully, count now: ' . $this->rowCount);
            return $user;

        } catch (\Exception $e) {
            \Log::error('Error processing row: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function rules(): array
    {
        return [
            // Since we're using array indices, validation is handled in model() method
            // Return empty array to skip validation
        ];
    }

    public function customValidationMessages()
    {
        return [
            // Since we're using array indices, validation messages are not used
            // Return empty array
        ];
    }

    public function onError(\Throwable $e)
    {
        // Skip error rows and continue processing
    }

    public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures)
    {
        // Skip failed rows and continue processing
    }
}
