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
            $table->string('dead_load')->default('0')->after('earthquake_load');
            $table->string('live_load')->default('0')->after('earthquake_load');

            $table->unsignedInteger('width')->default(0);
            $table->unsignedInteger('length')->default(0);
            $table->unsignedInteger('height')->default(0);
            $table->unsignedInteger('column_number')->default(0);

            $table->unsignedInteger('beam_w')->default(0);
            $table->unsignedInteger('beam_h')->default(0);
            $table->unsignedInteger('column_w')->default(0);
            $table->unsignedInteger('column_h')->default(0);
            $table->unsignedInteger('top_plate_w')->default(0);
            $table->unsignedInteger('top_plate_h')->default(0);
            $table->unsignedInteger('long_sill_w')->default(0);
            $table->unsignedInteger('long_sill_h')->default(0);

            $table->string('joint1')->nullable();
            $table->string('joint2')->nullable();
            $table->string('joint3')->nullable();
            $table->string('joint4')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn('dead_load');
            $table->dropColumn('live_load');

            $table->dropColumn('width');
            $table->dropColumn('length');
            $table->dropColumn('height');
            $table->dropColumn('column_number');

            $table->dropColumn('beam_w');
            $table->dropColumn('beam_h');
            $table->dropColumn('column_w');
            $table->dropColumn('column_h');
            $table->dropColumn('top_plate_w');
            $table->dropColumn('top_plate_h');
            $table->dropColumn('long_sill_w');
            $table->dropColumn('long_sill_h');

            $table->dropColumn('joint1');
            $table->dropColumn('joint2');
            $table->dropColumn('joint3');
            $table->dropColumn('joint4');
        });
    }
};
