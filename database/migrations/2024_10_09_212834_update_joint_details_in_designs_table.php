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
            $table->dropColumn('joint_d');
            $table->dropColumn('joint_lim_e');
            $table->dropColumn('joint_lim_s');
            $table->dropColumn('joint_lim_v');
            $table->dropColumn('joint_lim_g');
        });

        Schema::table('designs', function (Blueprint $table) {
            $table->float('joint1_dtl_clm')->default(0.0);
            $table->float('joint1_dtj_clm')->default(0.0);
            $table->float('joint1_btl_clm')->default(0.0);
            $table->float('joint1_ttl_clm')->default(0.0);
            $table->float('joint1_b_clm')->default(0.0);

            $table->float('joint2_jc1')->default(0.0);
            $table->float('joint2_jc2')->default(0.0);
            $table->float('joint2_jc3')->default(0.0);
            $table->float('joint2_jc4')->default(0.0);
            $table->float('joint2_jc5')->default(0.0);
            $table->float('joint2_jc6')->default(0.0);
            $table->float('joint2_jc7')->default(0.0);

            $table->float('joint3_lim_e')->default(0.0);
            $table->float('joint3_lim_s')->default(0.0);
            $table->float('joint3_lim_v')->default(0.0);
            $table->float('joint3_lim_g')->default(0.0);
            $table->float('joint3_lim_t')->default(0.0);
            $table->float('joint3_wtb')->default(0.0);
            $table->float('joint3_wt')->default(0.0);
            $table->float('joint3_tt')->default(0.0);
            $table->float('joint3_s2_clm')->default(0.0);

            $table->float('joint4_btucl')->default(0.0);
            $table->float('joint4_ttu_clm')->default(0.0);
            $table->float('joint4_gu_sb')->default(0.0);
            $table->float('joint4_esb')->default(0.0);
            $table->float('joint4_leu_sb')->default(0.0);
            $table->float('joint4_lsus')->default(0.0);
            $table->float('joint4_glsb')->default(0.0);
            $table->float('joint4_lsb')->default(0.0);
            $table->float('joint4_tb')->default(0.0);
            $table->float('joint4_wb')->default(0.0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn('joint1_dtl_clm');
            $table->dropColumn('joint1_dtj_clm');
            $table->dropColumn('joint1_btl_clm');
            $table->dropColumn('joint1_ttl_clm');
            $table->dropColumn('joint1_b_clm');

            $table->dropColumn('joint2_jc1');
            $table->dropColumn('joint2_jc2');
            $table->dropColumn('joint2_jc3');
            $table->dropColumn('joint2_jc4');
            $table->dropColumn('joint2_jc5');
            $table->dropColumn('joint2_jc6');
            $table->dropColumn('joint2_jc7');

            $table->dropColumn('joint3_lim_e');
            $table->dropColumn('joint3_lim_s');
            $table->dropColumn('joint3_lim_v');
            $table->dropColumn('joint3_lim_g');
            $table->dropColumn('joint3_lim_t');
            $table->dropColumn('joint3_wtb');
            $table->dropColumn('joint3_wt');
            $table->dropColumn('joint3_tt');
            $table->dropColumn('joint3_s2_clm');

            $table->dropColumn('joint4_btucl');
            $table->dropColumn('joint4_ttu_clm');
            $table->dropColumn('joint4_gu_sb');
            $table->dropColumn('joint4_esb');
            $table->dropColumn('joint4_leu_sb');
            $table->dropColumn('joint4_lsus');
            $table->dropColumn('joint4_glsb');
            $table->dropColumn('joint4_lsb');
            $table->dropColumn('joint4_tb');
            $table->dropColumn('joint4_wb');

            //---------------------------------------------------
            $table->float('joint_d')->default(0.0);
            $table->float('joint_lim_e')->default(0.0);
            $table->float('joint_lim_s')->default(0.0);
            $table->float('joint_lim_v')->default(0.0);
            $table->float('joint_lim_g')->default(0.0);
        });
    }
};
