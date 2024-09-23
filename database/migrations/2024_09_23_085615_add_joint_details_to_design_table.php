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
            $table->float('joint_d')->default(0.0);
            $table->float('joint_lim_e')->default(0.0);
            $table->float('joint_lim_s')->default(0.0);
            $table->float('joint_lim_v')->default(0.0);
            $table->float('joint_lim_g')->default(0.0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn('joint_d');
            $table->dropColumn('joint_lim_e');
            $table->dropColumn('joint_lim_s');
            $table->dropColumn('joint_lim_v');
            $table->dropColumn('joint_lim_g');

        });
    }
};
