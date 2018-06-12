<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platja extends Model
{
  protected $table = 'platges';

  protected $guarded = [];

  public function municipi()
  {
    return $this->belongsTo(Municipi::class);
  }

  public function previsions()
  {
    return $this->hasMany(Previsio::class)->where('tipus', '=', Previsio::PREVISIO_PLATJES)->latest('data_previsio')->take(2);
  }
}
