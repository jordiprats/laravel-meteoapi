<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrevisiosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('previsios', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('tipus');
      $table->timestamp('data_previsio');
      // previsió platges
      // data	"2018-05-16T00:00Z"
      // variables
      // 0
      // nom	"temperatura"
      // valor	13.100732421875023
      // 1
      // nom	"humitat_relativa"
      // valor	87.38972473144531
      // 2
      // nom	"velocitat_vent"
      // valor	3.0967717947992295
      // 3
      // nom	"direccio_vent"
      // valor	23.067368164464455
      // 4
      // nom	"estat_cel"
      // valor	1
      // 5
      // nom	"altura_ona"
      // valor	0.15920792520046234
      // 6
      // nom	"direccio_ona"
      // valor	281.615234375
      // 7
      // nom	"temperatura_aigua"
      // valor	17.0240535736084
      // 8
      // nom	"uvi_maxim"
      // valor	0
      // 9
      // nom	"uvi_previst"
      // valor	0
      // 1
      //
      //TODO: previsió municipal
      $table->double('temperatura', 16, 16)->nullable();
      $table->double('humitat_relativa', 16, 16)->nullable();
      $table->double('velocitat_vent', 16, 16)->nullable();
      $table->double('direccio_vent', 16, 16)->nullable();
      $table->integer('estat_cel')->nullable();
      $table->double('altura_ona', 16, 16)->nullable();
      $table->double('direccio_ona', 16, 16)->nullable();
      $table->double('temperatura_aigua', 16, 16)->nullable();
      $table->integer('uvi_maxim')->nullable();
      $table->integer('uvi_previst')->nullable();
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
    Schema::dropIfExists('previsios');
  }
}
