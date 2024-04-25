<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('users', function (Blueprint $table) {
			$table->boolean('asepvp_start_kit')->default(false)->after('discord_id');
            $table->boolean('asepve_start_kit')->default(false)->after('discord_id');
            $table->boolean('asapvp_start_kit')->default(false)->after('discord_id');
            $table->boolean('asapve_start_kit')->default(false)->after('discord_id');
		});
	}

	public function down(): void
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('asepvp_start_kit');
            $table->dropColumn('asepve_start_kit');
            $table->dropColumn('asapvp_start_kit');
            $table->dropColumn('asapve_start_kit');
		});
	}
};
