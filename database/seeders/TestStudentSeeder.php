<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Biodata;
use App\Models\Dad;
use App\Models\Mom;
use App\Models\Group;
use App\Models\Year;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat tahun ajaran
        $year = Year::firstOrCreate(
            ['tahun_ajaran' => '2024/2025'],
            ['status' => 'active']
        );

        // Buat kelas
        $group = Group::firstOrCreate(
            ['nama' => 'X IPA 1'],
            ['uri' => Str::slug('X IPA 1')]
        );

        // Buat siswa test
        $user = User::create([
            'year_id' => $year->id,
            'group_id' => $group->id,
            'nama_lengkap' => 'Ahmad Surya',
            'nisn' => '1234567890',
            'nis' => '2024001',
            'status' => 'active',
            'email' => 'ahmad.surya@example.com',
            'password' => Hash::make('1234567890'), // Password default NISN
            'jenis_kelamin' => 'Laki-laki',
        ]);

        // Buat biodata
        Biodata::create([
            'user_id' => $user->id,
            'uri' => Str::slug('Ahmad Surya-1234567890'),
            'alamat' => 'Jl. Contoh No. 123',
            'sekolah_asal' => 'SMP Negeri 1 Jakarta',
            'kota' => 'Jakarta',
            'kecamatan' => 'Menteng',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2009-05-15',
            'anak_ke' => 1,
            'jlh_saudara' => 2,
            'saudara_tiri' => 0,
            'saudara_angkat' => 0,
            'bahasa' => 'Indonesia',
            'agama' => 'Islam',
            'jarak' => 5,
            'nomor_hp' => '081234567890',
            'goldar' => 'O',
            'tinggi' => 165,
            'berat' => 55,
            'penyakit' => '-',
            'hobi' => 'Membaca, Olahraga',
            'kewarganegaraan' => 'Indonesia',
        ]);

        // Buat data ayah
        Dad::create([
            'user_id' => $user->id,
            'uri' => Str::slug('Budi Surya-ayah-1234567890'),
            'nama' => 'Budi Surya',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1975-03-10',
            'agama' => 'Islam',
            'kewarganegaraan' => 'Indonesia',
            'pekerjaan' => 'Pegawai Swasta',
            'pendidikan' => 'S1 Teknik Informatika',
            'penghasilan' => 5000000,
            'alamat' => 'Jl. Contoh No. 123',
            'nomor_hp' => '081234567891',
            'status' => 'Kandung',
        ]);

        // Buat data ibu
        Mom::create([
            'user_id' => $user->id,
            'uri' => Str::slug('Siti Aminah-ibu-1234567890'),
            'nama' => 'Siti Aminah',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1978-08-20',
            'agama' => 'Islam',
            'kewarganegaraan' => 'Indonesia',
            'pekerjaan' => 'Ibu Rumah Tangga',
            'pendidikan' => 'SMA',
            'penghasilan' => 0,
            'alamat' => 'Jl. Contoh No. 123',
            'nomor_hp' => '081234567892',
            'status' => 'Kandung',
        ]);

        $this->command->info('✅ Data siswa test berhasil dibuat!');
        $this->command->info('Email: ahmad.surya@example.com');
        $this->command->info('Password: 1234567890 (NISN)');
    }
}
