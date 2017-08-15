<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalExpressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_expresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kraj');
            $table->string('unique_id');
            $table->string('masa');
            $table->string('cena')->nullable();
            $table->string('strefa')->nullable();
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
        Schema::dropIfExists('global_expresses');
    }
}
