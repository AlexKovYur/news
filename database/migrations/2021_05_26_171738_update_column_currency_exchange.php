<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnCurrencyExchange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('currency_exchange', function (Blueprint $table) {
            $table->renameColumn('currency', 'currency_symbol');
            $table->string('currency_name');
            $table->renameColumn('change', 'change_24h');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        dd('для перехода на более раннюю версию сделать новую миграцию');
    }
}
