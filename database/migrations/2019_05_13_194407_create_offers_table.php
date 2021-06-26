<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable('offers') ) {
            Schema::create('offers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('fiat_currency')->nullable();
                $table->string('payment_method')->nullable();
                $table->string('min_amount')->nullable();
                $table->string('max_amount')->nullable();
                $table->string('margin_percentage')->nullable();
                $table->string('final_offer')->nullable();
                $table->boolean('status')->nullable();
                $table->integer('owner_user_id')->nullable();
                $table->integer('traded_by_user_id')->nullable();
                $table->string('trade_offer')->nullable();
                $table->string('trade_status')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
