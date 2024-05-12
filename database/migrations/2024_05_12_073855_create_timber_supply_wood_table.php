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
        Schema::create('timber_supply_wood', function (Blueprint $table) {
            $table->unsignedBigInteger('timber_supply_id');
            $table->unsignedBigInteger('wood_id');

            $table->foreign('timber_supply_id')->references('id')->on('timber_supplies');
            $table->foreign('wood_id')->references('id')->on('wood');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timber_supply_wood');
    }
};
