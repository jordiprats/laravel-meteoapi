<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comarca extends Model
{
  protected $table = 'comarques';

  protected $guarded = [];

  public function municipis()
  {
    return $this->hasMany(Municipi::class);
  }
}
