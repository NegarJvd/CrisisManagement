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
            $table->dropColumn(['file_path', 'snow_load', 'wind_load', 'earthquake_load', 'live_load', 'dead_load', 'number_of_households']);

            $table->float('width')->default(0.0)->change();
            $table->float('length')->default(0.0)->change();
            $table->float('height')->default(0.0)->change();
            $table->float('beam_w')->default(0.0)->change();
            $table->float('beam_h')->default(0.0)->change();
            $table->float('top_plate_w')->default(0.0)->change();
            $table->float('top_plate_h')->default(0.0)->change();
            $table->float('long_sill_w')->default(0.0)->change();
            $table->float('long_sill_h')->default(0.0)->change();
            $table->float('column_h')->default(0.0)->change();
            $table->float('column_W')->default(0.0)->change();

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
