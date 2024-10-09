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
            $table->float('partial_factor')->default(0.0);
            $table->float('density')->default(0.0);
            $table->float('bending_strength')->default(0.0)->change();
            $table->float('shear_strength')->default(0.0)->change();
            $table->float('compression_parallel')->default(0.0)->change();
            $table->float('compression_perpendicular')->default(0.0)->change();
            $table->float('tension_parallel')->default(0.0)->change();
            $table->float('tension_perpendicular')->default(0.0)->change();
            $table->float('e_modulus')->default(0.0)->change();
            $table->float('e_modulus_5')->default(0.0);
            $table->float('modification_factor_permanent_term')->default(0.0);
            $table->float('modification_factor_medium_term')->default(0.0);
            $table->float('modification_factor_instantaneous_term')->default(0.0);
            $table->float('creep_factor')->default(0.0);
            $table->float('creep_factor_solid_timber')->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wood', function (Blueprint $table) {
            $table->dropColumn('partial_factor');
            $table->dropColumn('density');
            $table->dropColumn('e_modulus_5');
            $table->dropColumn('modification_factor_permanent_term');
            $table->dropColumn('modification_factor_medium_term');
            $table->dropColumn('modification_factor_instantaneous_term');
            $table->dropColumn('creep_factor');
            $table->dropColumn('creep_factor_solid_timber');
        });
    }
};
