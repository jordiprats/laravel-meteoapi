<?php

namespace App\Http\Controllers;

use App\Platja;
use Illuminate\Http\Request;
use App\Http\Resources\PlatjaResource;
use App\Http\Resources\PrevisionsResource;
use Illuminate\Support\Facades\Log;
use App\Jobs\GetPrevisioPlatja;

class PlatjaController extends Controller
{
  public static function getPlatges()
  {
    $c = curl_init('http://meteo.cat/prediccio/platges');
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) Gecko/20100101 Firefox/59.0');
    //curl_setopt(... other options you want...)

    $html = curl_exec($c);

    if (curl_error($c))
        die(curl_error($c));

    // Get the status code
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);

    curl_close($c);

    preg_match('/metadadesPuntsPlatges: (.*),/', $html, $matches, PREG_OFFSET_CAPTURE);

    return json_decode($matches[1][0]);
  }

  public function index()
  {
    return [ 'platges' => 'TODO' ];
  }

  public function show($municipi_slug, $platja_slug)
  {
    $platja=Platja::where(['slug'=>$platja_slug])->first();

    if($platja)
    {
      if($platja->municipi->slug!=$municipi_slug)
        return NULL;
      else
        return new PlatjaResource($platja);
    }
    else
      return NULL;
  }

  public function previsio($municipi_slug, $platja_slug)
  {
    $platja=Platja::where(['slug'=>$platja_slug])->first();

    if($platja)
    {
      if($platja->municipi->slug!=$municipi_slug)
      {
        return response()->json([
          'previsio' => NULL,
        ], 404);
      }
      else
      {
        if($platja->previsions->count()==0)
        {
          try
          {
            Log::info("scheduled job GetPrevisioPlatja: ".$platja_slug);
            dispatch(new GetPrevisioPlatja($platja_slug));
          }
          catch(\Exception $e)
          {
            Log::info("-_(._.)_-");
            Log::info($e);
          }

          return response()->json([
            'previsio' => NULL,
          ], 503);
        }
        else
          return new PrevisionsResource($platja->previsions);
      }
    }
    else
      return response()->json([
        'previsio' => NULL,
      ], 404);
  }

}
