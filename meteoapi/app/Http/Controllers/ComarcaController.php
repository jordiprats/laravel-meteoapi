<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ComarquesResource;
use App\Http\Resources\MunicipisResource;
use App\Comarca;

class ComarcaController extends Controller
{
  public function index()
  {
    return new ComarquesResource(Comarca::all());
  }

  public function show($comarca_slug)
  {
    $comarca = Comarca::where(['slug'=>$comarca_slug])->first();
    return new MunicipisResource($comarca->municipis);
  }
}
