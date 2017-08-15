<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStrefyPrzesylkiPocztoweTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strefy_przesylek_pocztowych_zagranicznych', function (Blueprint $table) {
           $table->increments('id'); 
           $table->string('strefa')->nullable(); 
           $table->string('nazwa_kraju'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('strefy_przesylek_pocztowych_zagranicznych');
    }
}
