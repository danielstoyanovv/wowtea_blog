<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentApisResponseHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_apis_response_history', function (Blueprint $table) {
            $table->id();
            $table->json('content');
            $table->json('response');
            $table->string('method')->nullable();
            $table->string('provider')->nullable();
            $table->json('provider_config')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_apis_response_history');
    }
}
