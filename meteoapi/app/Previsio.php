<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Previsio extends Model
{
  public const PREVISIO_PLATJES=1;
  public const PREVISIO_MUNICIPAL=2;

  protected $table = 'previsions';
  protected $guarded = [];

  public function platja()
  {
    return $this->belongsTo(Platja::class,'platja_id');
  }

  public function municipi()
  {
    return $this->belongsTo(Municipi::class,'municipi_id');
  }
}
