<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Raporty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('raporty', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id');
            $table->string('rodzaj_przesylki');
            $table->float('masa[g]');
            $table->integer('ilosc');
            $table->string('gabaryt')->nullable();
            $table->string('usluga')->nullable();
            $table->string('stawkaVat');
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
        Schema::dropIfExists('raporty');
    }
}
