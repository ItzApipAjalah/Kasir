<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('pay', 15, 2)->after('total')->nullable()->comment('Amount of cash received from the customer');
            $table->decimal('refund', 15, 2)->after('pay')->nullable()->comment('Change returned to the customer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['pay', 'refund']);
        });
    }
};
