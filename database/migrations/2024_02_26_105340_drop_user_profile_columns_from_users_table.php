<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'global_name',
                'profile_photo_path',
                'avatar',
                'banner',
                'banner_color',
                'accent_color',
                'locale',
                'public_flags',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->after('id');
            $table->string('profile_photo_path')->nullable()->after('username');
            $table->string('avatar')->nullable()->after('profile_photo_path');
            $table->string('banner')->nullable()->after('avatar');
            $table->string('banner_color')->nullable()->after('banner');
            $table->string('accent_color')->nullable()->after('banner_color');
            $table->string('locale')->nullable()->after('accent_color');
            $table->bigInteger('public_flags')->nullable()->after('locale');
        });
    }
};
