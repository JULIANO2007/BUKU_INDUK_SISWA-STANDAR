<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToBiodatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biodatas', function (Blueprint $table) {
            $table->string('mpsn_mpn_mmt')->nullable()->after('sekolah_asal');
            $table->string('nik_no_kk')->nullable()->after('mpsn_mpn_mmt');
            $table->string('rt_rw')->nullable()->after('nik_no_kk');
            $table->string('kode_pos')->nullable()->after('rt_rw');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biodatas', function (Blueprint $table) {
            $table->dropColumn(['mpsn_mpn_mmt', 'nik_no_kk', 'rt_rw', 'kode_pos']);
        });
    }
}
