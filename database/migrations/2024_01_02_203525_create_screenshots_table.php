<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('screenshots', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('path');
            $table->unsignedBigInteger('uploaded_by');
            $table->unsignedBigInteger('created_by');
            $table->foreign('uploaded_by')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screenshots');
    }
};
