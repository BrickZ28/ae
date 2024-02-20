<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('specials', function (Blueprint $table) {
			$table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('discount')->nullable(); // Assuming a decimal type for discount
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('usage_limit')->nullable();
            $table->boolean('active')->default(false);
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('specials');
	}
};
