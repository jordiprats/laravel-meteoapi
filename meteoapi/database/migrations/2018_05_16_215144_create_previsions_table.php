<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrevisionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('previsions', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('tipus');
      $table->integer('platja_id')->nullable()->references('id')->on('platges');
      $table->timestamp('data_previsio');
      $table->unique(['platja_id', 'data_previsio'], 'platja_data_unique');
      //
      // previsió platges - tipus 1
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
      $table->decimal('temperatura', 5, 2)->nullable();
      $table->decimal('humitat_relativa', 5, 2)->nullable();
      $table->decimal('velocitat_vent', 5, 2)->nullable();
      $table->decimal('direccio_vent', 5, 2)->nullable();
      $table->integer('estat_cel')->nullable();
      $table->decimal('altura_ona', 5, 2)->nullable();
      $table->decimal('direccio_ona', 5, 2)->nullable();
      $table->decimal('temperatura_aigua', 5, 2)->nullable();
      $table->integer('uvi_maxim')->nullable();
      $table->integer('uvi_previst')->nullable();
      $table->timestamps();
      //
      // previsió municipal - tipus 2
      // 'tmax': [24, 23, 25, 26, 26, 26],
      // 'tmin': [16, 16, 17, 18, 19, 19],
      // 'pprec': [66, 64, 28, 31, 30, 28],
      // 'estatcel':
      $table->integer('municipi_id')->nullable()->references('id')->on('municipis');
      $table->integer('temperatura_max')->nullable();
      $table->integer('temperatura_min')->nullable();
      $table->integer('probabilitat_precipitacio')->nullable();
      //estat_cel compartit amb tipus 1
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('previsions');
  }
}
