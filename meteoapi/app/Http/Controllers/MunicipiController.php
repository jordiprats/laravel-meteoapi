<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\MunicipisResource;
use App\Http\Resources\MunicipiResource;
use App\Http\Resources\PrevisionsResource;
use App\Http\Resources\PlatgesResource;
use App\Municipi;
use Illuminate\Support\Facades\Log;
use App\Jobs\GetPrevisioMunicipal;
use Illuminate\Support\Facades\DB;

class MunicipiController extends Controller
{
  public static function toStrCmp(string $string)
  {
    $conectors = array('i', 'a', 'de', 'del', 'dels', 'les', 'el', 'la', 'd\'', '-', 'l\'', ',');

    $output = strtolower($string);
    $output = preg_replace('/\b('.implode('|',$conectors).')\b/','',$output);
    $output = trim(preg_replace('/\s+/', '', str_replace("\n", "", $output)));
    $output = str_slug($output, '');

    return $output;
  }

  public static function getMunicipis()
  {
    $c = curl_init('http://meteo.cat/prediccio/municipal');
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) Gecko/20100101 Firefox/59.0');
    //curl_setopt(... other options you want...)

    $html = curl_exec($c);

    if (curl_error($c))
        die(curl_error($c));

    // Get the status code
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);

    curl_close($c);

    preg_match('/Meteocat.cercadorMunicipi\(([^\)]*)\)/', $html, $matches, PREG_OFFSET_CAPTURE);

    return json_decode($matches[1][0]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return new MunicipisResource(Municipi::all());
  }

  public function show($municipi_slug)
  {
    $municipi = Municipi::where(['slug'=>$municipi_slug])->first();
    return new MunicipiResource($municipi);
  }

  public function geoSearch($latitude, $longitude)
  {
    //ORDER BY ((lat-$user_lat)*(lat-$user_lat)) + ((lng - $user_lng)*(lng - $user_lng)) ASC
    // $municipi_raw = DB::table('municipis')
    //   ->orderByRaw('((municipis.latitude-'.$latitude.')*(municipis.latitude-'.$latitude.')) + ((municipis.longitude - '.$longitude.')*(municipis.longitude - '.$longitude.')) ASC')
    //   ->take(5)
    //   ->get();
    $municipis_raw = DB::table('municipis')
      ->select(DB::raw('*, 6371 * acos (
        cos ( radians('.$latitude.') )
      * cos( radians( municipis.latitude ) )
      * cos( radians( municipis.longitude ) - radians('.$longitude.') )
      + sin ( radians('.$latitude.') )
      * sin( radians( municipis.latitude ) )
      ) as distance'))
      ->havingRaw('distance < ?', [15])
      ->orderByRaw('distance')
      ->take(5)
      ->get();
    Log::info(print_r($municipis_raw, true));

    $municipis = Municipi::hydrate($municipis_raw->toArray());
    //$municipi = Municipi::where(['slug'=>$municipi_slug])->first();
    return new MunicipisResource($municipis);
  }

  public function previsio($municipi_slug)
  {
    $municipi = Municipi::where(['slug'=>$municipi_slug])->first();
    if($municipi->previsions->count()==0)
    {
      try
      {
        Log::info("scheduled job GetPrevisioMunicipal: ".$municipi_slug);
        dispatch(new GetPrevisioMunicipal($municipi_slug));
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
      return new PrevisionsResource($municipi->previsions);
  }

  public function platges($municipi_slug)
  {
    $municipi = Municipi::where(['slug'=>$municipi_slug])->first();
    return new PlatgesResource($municipi->platges);
  }
}
