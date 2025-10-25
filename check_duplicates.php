<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "Checking for duplicate URIs...\n";

try {
    // Check biodatas
    $dupBio = DB::select('SELECT uri, COUNT(*) as count FROM biodatas GROUP BY uri HAVING count > 1');
    echo "Biodatas with duplicate URIs: " . count($dupBio) . "\n";
    foreach($dupBio as $b) {
        echo "  - {$b->uri} (count: {$b->count})\n";
    }

    // Check dads
    $dupDad = DB::select('SELECT uri, COUNT(*) as count FROM dads GROUP BY uri HAVING count > 1');
    echo "Dads with duplicate URIs: " . count($dupDad) . "\n";
    foreach($dupDad as $d) {
        echo "  - {$d->uri} (count: {$d->count})\n";
    }

    // Check moms
    $dupMom = DB::select('SELECT uri, COUNT(*) as count FROM moms GROUP BY uri HAVING count > 1');
    echo "Moms with duplicate URIs: " . count($dupMom) . "\n";
    foreach($dupMom as $m) {
        echo "  - {$m->uri} (count: {$m->count})\n";
    }

    echo "Done.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
