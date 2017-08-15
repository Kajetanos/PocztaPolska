<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id');
            $table->string('rodzaj_przesylki');
            $table->float('masa');
            $table->integer('ilosc');
            $table->string('gabaryt')->nullable();
            $table->string('usluga')->nullable();
            $table->string('stawkaVat');
            $table->string('kraj');
            $table->string('date');
            $table->string('ubezpieczenia')->nullable();
            
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
        Schema::dropIfExists('raports');
    }
}
