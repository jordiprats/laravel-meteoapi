<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipi extends Model
{
  protected $guarded = [];

  public function comarca()
  {
    return $this->belongsTo(Comarca::class);
  }

  public function platges()
  {
    return $this->hasMany(Platja::class);
  }

  public function previsions()
  {
    return $this->hasMany(Previsio::class)->where('tipus', '=', Previsio::PREVISIO_MUNICIPAL)->latest('data_previsio')->take(7);
  }
}
