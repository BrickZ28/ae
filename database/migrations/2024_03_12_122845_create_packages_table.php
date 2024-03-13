<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('packages', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->text('description');
			$table->decimal('price');
            $table->string('image')->nullable();
            $table->boolean('visible')->default(true);
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('packages');
	}
};
