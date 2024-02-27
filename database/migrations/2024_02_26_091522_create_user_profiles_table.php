<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('user_profiles', function (Blueprint $table) {
			$table->id();
			$table->string('global_name')->nullable();
			$table->string('profile_photo_path')->nullable();
			$table->string('avatar')->nullable();
			$table->string('banner')->nullable();
			$table->string('local')->nullable();
			$table->bigInteger('public_flags')->nullable();
			$table->foreignId('user_id')->unique()->nullable()->constrained('users')->cascadeOnDelete();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('user_profiles');
	}
};
