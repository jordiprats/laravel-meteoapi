<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\MunicipisResource;
use App\Municipi;

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

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Municipi  $municipi
   * @return \Illuminate\Http\Response
   */
  public function show($municipi_id)
  {
    return [ 'prediccio' => 'TODO' ];
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Municipi  $municipi
   * @return \Illuminate\Http\Response
   */
  public function edit(Municipi $municipi)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Municipi  $municipi
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Municipi $municipi)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Municipi  $municipi
   * @return \Illuminate\Http\Response
   */
  public function destroy(Municipi $municipi)
  {
      //
  }
}
