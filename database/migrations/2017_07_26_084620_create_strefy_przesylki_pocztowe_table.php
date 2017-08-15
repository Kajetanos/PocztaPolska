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
           $table->string('nazwa_kraju'); 
           $table->string('strefaI')->nullable(); 
           $table->string('strefaII')->nullable(); 
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
