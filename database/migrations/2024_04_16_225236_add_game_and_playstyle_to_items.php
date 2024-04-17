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
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id')->nullable()->after('currency_type');
            $table->unsignedBigInteger('playstyle_id')->nullable()->after('game_id');

            $table->foreign('game_id')->references('id')->on('games')->onDelete('set null');
            $table->foreign('playstyle_id')->references('id')->on('playstyles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }
};
