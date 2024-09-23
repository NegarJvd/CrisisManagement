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
        Schema::table('wood', function (Blueprint $table) {
            $table->unsignedInteger('bending_strength')->default(0);
            $table->unsignedInteger('tension_parallel')->default(0);
            $table->unsignedInteger('tension_perpendicular')->default(0);
            $table->unsignedInteger('compression_parallel')->default(0);
            $table->unsignedInteger('compression_perpendicular')->default(0);
            $table->unsignedInteger('shear_strength')->default(0);
            $table->unsignedInteger('e_modulus')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wood', function (Blueprint $table) {
            $table->dropColumn('bending_strength');
            $table->dropColumn('tension_parallel');
            $table->dropColumn('tension_perpendicular');
            $table->dropColumn('compression_parallel');
            $table->dropColumn('compression_perpendicular');
            $table->dropColumn('shear_strength');
            $table->dropColumn('e_modulus');
        });
    }
};
