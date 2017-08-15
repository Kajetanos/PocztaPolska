<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrzesylkiZagranicznesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('przesylki_zagranicznes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id')->unique();
            $table->string('rodzaj_przesylki');
            $table->string('masa');
            $table->string('ilosc');
            $table->string('gabaryt');
            $table->string('usluga');
            $table->string('stawkaVat');
            $table->string('kraj');
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
        Schema::dropIfExists('przesylki_zagranicznes');
    }
}
