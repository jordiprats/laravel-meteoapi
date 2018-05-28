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
        $table->string('nom');
        $table->string('slug')->nullable();
        $table->unique('slug');
        $table->double('latitude', 10, 6);
        $table->integer('latitude_ceil');
        $table->index('latitude_ceil');
        $table->double('longitude', 10, 6);
        $table->integer('longitude_ceil');
        $table->index('longitude_ceil');
        $table->integer('municipi_id')->references('id')->on('municipis');
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
