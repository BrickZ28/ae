<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->after('id'); // Add an order_id column
            $table->string('payee_type')->nullable()->after('payee_id'); // Add a payee_type column
            $table->string('currency_type')->nullable()->after('amount'); // Add a currency_type column
            $table->string('payer_type')->nullable()->after('payer_id'); // Add a payer_type column

            $table->unsignedBigInteger('payer_id')->nullable()->change();
            $table->unsignedBigInteger('payee_id')->nullable()->change();


            $table->foreign('order_id')->references('id')->on('orders'); // Add foreign key constraint
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['order_id']); // Drop foreign key constraint

            $table->dropColumn('order_id'); // Drop the order_id column
            $table->dropColumn('payee_type'); // Drop the payee_type column
            $table->dropColumn('currency_type'); // Drop the currency_type column
            $table->dropColumn('payer_type'); // Drop the payer_type column
            $table->unsignedBigInteger('payer_id')->change();

            $table->unsignedBigInteger('payee_id')->change();

        });
    }
};
