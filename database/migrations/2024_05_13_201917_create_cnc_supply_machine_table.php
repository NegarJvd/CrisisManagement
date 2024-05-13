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
        Schema::create('cnc_supply_machine', function (Blueprint $table) {
            $table->unsignedBigInteger('cnc_supply_id');
            $table->unsignedBigInteger('machine_id');

            $table->foreign('cnc_supply_id')->references('id')->on('cnc_supplies');
            $table->foreign('machine_id')->references('id')->on('machines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cnc_supply_machine');
    }
};
