<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('servers', function (Blueprint $table) {
			$table->string('serverhost_id');
            $table->string('comments')->nullable();
            $table->string('slots');
            $table->string('game');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->boolean('crossplay');
            $table->string('status');
		});
	}

	public function down(): void
	{
		Schema::table('servers', function (Blueprint $table) {
			//
		});
	}
};
