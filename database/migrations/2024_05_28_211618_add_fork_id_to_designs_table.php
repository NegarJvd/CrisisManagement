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
            $table->unsignedBigInteger('fork_id')->nullable()->after('user_id');
            $table->foreign('fork_id')->references('id')->on('designs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->dropForeign('fork_id');
            $table->dropColumn(['fork_id']);
        });
    }
};
