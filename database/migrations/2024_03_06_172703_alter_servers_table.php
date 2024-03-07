<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('servers', function (Blueprint $table) {
			$table->dropColumn('crossplay');

            $table->foreignId('playstyle_id')->nullable()->constrained()->cascadeOnDelete();

            $table->string('display_name')->nullable();
		});
	}

	public function down(): void
	{
		Schema::table('servers', function (Blueprint $table) {
			$table->string('crossplay')->nullable();

            $table->dropForeign(['playstyle_id']);
            $table->dropColumn('playstyle_id');

            $table->dropColumn('display_name');
		});
	}
};
