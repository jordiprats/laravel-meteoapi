<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComarquesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // comarca
    // codi	25
    // nom	"Pallars Jussà"
    Schema::create('comarques', function (Blueprint $table) {
      $table->increments('id');
      $table->string('nom');
      $table->string('slug');
      $table->unique('slug');
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
    Schema::dropIfExists('comarques');
  }
}
