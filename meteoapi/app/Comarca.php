<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comarca extends Model
{
  protected $table = 'comarques';
  
  // everything is mass assignable
  protected $guarded = [];
}
