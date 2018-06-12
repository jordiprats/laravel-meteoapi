<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipi extends Model
{
  protected $guarded = [];

  public function platjes()
  {
    return $this->hasMany(Platja::class);
  }

  public function previsions()
  {
    return $this->hasMany(Previsio::class)->where('tipus', '=', Previsio::PREVISIO_MUNICIPAL);
  }
}
