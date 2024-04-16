<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gates', function (Blueprint $table) {
            $table->id();
            $table->string('gate_id')->unique();
            $table->string('pin')->nullable();
            $table->foreignId('player_id')->nullable()->constrained('users');
            $table->foreignId('admin_id')->nullable()->constrained('users');
            $table->foreignId('playstyle_id')->nullable()->constrained('playstyles');
            $table->dateTime('last_fed')->nullable();
            $table->timestamps();

            $table->unique(['gate_id', 'playstyle_id']);
        });

        Schema::create('gate_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gate_id')->constrained('gates');
            $table->foreignId('item_id')->constrained('items');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gate_item');
        Schema::dropIfExists('gates');
    }
};
