<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('global_name')->nullable();
            $table->string('discriminator')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('verified')->nullable();
            $table->string('banner')->nullable();
            $table->string('banner_color')->nullable();
            $table->string('accent_color')->nullable();
            $table->string('locale')->nullable();
            $table->tinyInteger('mfa_enabled')->nullable();
            $table->string('premium_type')->nullable();
            $table->string('public_flags')->nullable();
            $table->datetime('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
