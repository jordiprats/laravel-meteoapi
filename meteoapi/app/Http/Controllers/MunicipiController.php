<?php

namespace App\Http\Controllers;

use App\Municipi;
use Illuminate\Http\Request;

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
    curl_setopt($c, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
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
    //TODO: caching
    $c = curl_init('http://meteo.cat/prediccio/municipal');
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    //curl_setopt(... other options you want...)

    $html = curl_exec($c);

    if (curl_error($c))
        die(curl_error($c));

    // Get the status code
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);

    curl_close($c);

    preg_match('/Meteocat.cercadorMunicipi\(([^\)]*)\)/', $html, $matches, PREG_OFFSET_CAPTURE);

    return [ 'municipis' => json_decode($matches[1][0]) ];
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
    //http://meteo.cat/prediccio/municipal/172023
    //TODO: caching
    $c = curl_init('http://meteo.cat/prediccio/municipal/'.$municipi_id);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    //curl_setopt(... other options you want...)

    $html = curl_exec($c);

    if (curl_error($c))
        die(curl_error($c));

    // Get the status code
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);

    curl_close($c);

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
