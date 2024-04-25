<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
        Schema::table('gates', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id')->after('id')->nullable(); // Add the game_id column

            $table->foreign('game_id') // Specify the foreign key
            ->references('id') // The column in the games table that the foreign key references
            ->on('games') // The table that the foreign key references
            ->onDelete('cascade'); // What to do when the referenced record is deleted
        });
	}

	public function down(): void
	{
        Schema::table('gates', function (Blueprint $table) {
            $table->dropForeign(['game_id']); // Drop the foreign key constraint
            $table->dropColumn('game_id'); // Drop the game_id column
        });
	}
};
