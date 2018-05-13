<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platges', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('data_previsio');
            $table->double('temperatura', 16, 16);
            $table->double('humitat_relativa', 16, 16);
            $table->double('velocitat_vent', 16, 16);
            $table->double('direccio_vent', 16, 16);
            $table->integer('estat_cel');
            $table->double('altura_ona', 16, 16);
            $table->double('direccio_ona', 16, 16);
            $table->double('temperatura_aigua', 16, 16);
            $table->integer('uvi_maxim');
            $table->integer('uvi_previst');
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
        Schema::dropIfExists('platges');
    }
}
