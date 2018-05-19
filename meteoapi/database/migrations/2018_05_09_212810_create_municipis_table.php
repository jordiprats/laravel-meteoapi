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
        $table->string('nom');
        $table->string('nom_strcmp');
        $table->unique('nom_strcmp');
        $table->string('slug')->nullable();
        $table->double('latitude', 10, 6);
        $table->integer('latitude_ceil');
        $table->index('latitude_ceil');
        $table->double('longitude', 10, 6);
        $table->integer('longitude_ceil');
        $table->index('longitude_ceil');
        $table->integer('comarca_id')->references('id')->on('comarques');
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
