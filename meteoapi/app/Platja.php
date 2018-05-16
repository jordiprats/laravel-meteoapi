<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platja extends Model
{
  protected $table = 'platges';

  // everything is mass assignable
  protected $guarded = [];
}
