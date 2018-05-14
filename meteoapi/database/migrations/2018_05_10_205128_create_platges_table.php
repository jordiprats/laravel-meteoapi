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
      // municipi	"Alcanar"
      // nom	"del Marjal"
      // coordenades
      // latitud	40.54525445
      // longitud	0.524413744
      // slug	"alcanar-del-marjal"
      Schema::create('platges', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('meteo_id');
        $table->string('nom');
        $table->string('slug')->nullable();
        $table->double('latitude', 10, 16);
        $table->double('longitude', 10, 16);
        $table->integer('municipi_id')->references('id')->on('municipis');
        $table->timestamps();
          // $table->increments('id');
          // $table->timestamp('data_previsio');
          // $table->double('temperatura', 16, 16);
          // $table->double('humitat_relativa', 16, 16);
          // $table->double('velocitat_vent', 16, 16);
          // $table->double('direccio_vent', 16, 16);
          // $table->integer('estat_cel');
          // $table->double('altura_ona', 16, 16);
          // $table->double('direccio_ona', 16, 16);
          // $table->double('temperatura_aigua', 16, 16);
          // $table->integer('uvi_maxim');
          // $table->integer('uvi_previst');
          // $table->timestamps();
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
