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
}
