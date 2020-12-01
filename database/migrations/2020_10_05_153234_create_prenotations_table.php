<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrenotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prenotations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('n_persone')->nullable();
            $table->date('data_arrivo')->nullable();
            $table->date('data_partenza')->nullable();
            $table->time('ora_arrivo')->nullable();
            $table->time('ora_partenza')->nullable();
            $table->integer('camera_id')->nullable();
            $table->boolean('has_animals')->nullable();
            $table->float('ricavo')->nullable();
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
        Schema::dropIfExists('prenotations');
    }
}
