<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('item_package', function (Blueprint $table) {
			$table->id();

            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();

			$table->timestamps();

            $table->unique(['item_id', 'package_id'], 'item_package_unique');
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('item_package');
	}
};
