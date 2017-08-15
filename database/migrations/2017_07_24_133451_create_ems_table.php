<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id');
            $table->string('strefa')->nullable();
            $table->string('masa');
            $table->string('ubezpieczenie')->nullable();
            $table->float('cena')->nullable();  
            $table->string('kraj');
            $table->string('date');
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
        Schema::dropIfExists('ems');
    }
}
