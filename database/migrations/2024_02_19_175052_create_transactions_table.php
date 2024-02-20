<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('transactions', function (Blueprint $table) {
			$table->id();

            $table->unsignedBigInteger('payer_id');
            $table->unsignedBigInteger('payee_id');
            $table->integer('amount');
            $table->string('reason');


            $table->foreign('payer_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('payee_id')->references('id')->on('users')->cascadeOnDelete();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('transactions');
	}
};
