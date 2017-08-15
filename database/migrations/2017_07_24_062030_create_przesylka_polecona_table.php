<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrzesylkaPoleconaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('przesylka_polecona', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gabaryt');
            $table->float ('masa');
            $table->float ('ilosc');
            $table->string('usluga')->nullable();
            $table->string('stawka_vat')->nullable();
            
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
        Schema::dropIfExists('przesylka_polecona');
    }
}
