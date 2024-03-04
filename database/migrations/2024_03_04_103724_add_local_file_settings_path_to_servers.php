<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('servers', function (Blueprint $table) {
			$table->string('local_file_settings_path')->nullable()->after('ip');
		});
	}

	public function down(): void
	{
		Schema::table('servers', function (Blueprint $table) {
			$table->dropColumn('local_file_settings_path');
		});
	}
};
