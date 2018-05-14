<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunicipisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // municipis
      // 0
      // codi	"250019"
      // variables	null
      // nom	"Abella de la Conca"
      // slug	null
      // coordenades
      // latitud	42.161303653992505
      // longitud	1.0917273756684647
      // comarca
      // codi	25
      // nom	"Pallars Jussà"
      Schema::create('municipis', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('meteo_id');
        $table->string('nom');
        $table->string('slug')->nullable();
        $table->double('latitude', 10, 16);
        $table->double('longitude', 10, 16);
        $table->integer('comarca_id')->references('id')->on('comarques')->nullable();
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
        Schema::dropIfExists('municipis');
    }
}
