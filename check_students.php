<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::where('status', 'siswa')->latest()->take(5)->get();

foreach ($users as $u) {
    echo $u->nama_lengkap . ' (' . $u->nisn . ') - ' . ($u->biodata ? 'Has biodata' : 'No biodata') . ', ' . ($u->ayah ? 'Has dad' : 'No dad') . ', ' . ($u->ibu ? 'Has mom' : 'No mom') . PHP_EOL;
}
