<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Previsio extends Model
{
  protected $table = 'previsions';

  protected $guarded = [];

  public function platja()
  {
    return $this->belongsTo(Platja::class,'platja_id');
  }
}
