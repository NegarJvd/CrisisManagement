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
            $table->float('dtl_e')->default(0.0);
            $table->float('dtl_g')->default(0.0);
            $table->float('dtl_s')->default(0.0);
            $table->float('dtl_v')->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wood', function (Blueprint $table) {
            $table->dropColumn('dtl_e');
            $table->dropColumn('dtl_g');
            $table->dropColumn('dtl_s');
            $table->dropColumn('dtl_v');
        });
    }
};
