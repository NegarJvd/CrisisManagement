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
        Schema::create('design_machine', function (Blueprint $table) {
            $table->unsignedBigInteger('design_id');
            $table->unsignedBigInteger('machine_id');

            $table->foreign('design_id')->references('id')->on('designs');
            $table->foreign('machine_id')->references('id')->on('machines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_machine');
    }
};
