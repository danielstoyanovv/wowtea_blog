<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_number');
            $table->string('expiry_month');
            $table->string('expiry_year');
            $table->string('security_code');
            $table->string('holder_name');
            $table->string('provider')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_cards');
    }
}
