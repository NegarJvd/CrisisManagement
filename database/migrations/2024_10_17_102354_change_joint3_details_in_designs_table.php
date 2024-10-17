<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->float('joint1_dtt_clm')->default(0.0)->after('joint1_ttl_clm');

            $table->float('joint3_d')->default(0.0)->after('joint3_lim_g');
            $table->dropColumn('joint3_lim_t');
            $table->dropColumn('joint3_wtb');
            $table->dropColumn('joint3_wt');
            $table->dropColumn('joint3_tt');
            $table->dropColumn('joint3_s2_clm');

            $table->float('joint4_d')->default(0.0)->after('joint4_btucl');
            $table->float('joint4_l_scr')->default(0.0)->after('joint4_btucl');
            $table->float('joint4_lsu_s_b')->default(0.0)->after('joint4_btucl');
            $table->dropColumn('joint4_lsus');
            $table->dropColumn('joint4_gu_sb');
            $table->dropColumn('joint4_lsb');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            //
        });
    }
};
