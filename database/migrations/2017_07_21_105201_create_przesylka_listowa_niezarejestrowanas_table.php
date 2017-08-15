<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrzesylkaListowaNiezarejestrowanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('przesylka_listowa_niezarejestrowanas', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('priorytet');  
            $table->boolean('gabaryt');
            $table->decimal('masa[g]');
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
        Schema::dropIfExists('przesylka_listowa_niezarejestrowanas');
    }
}
