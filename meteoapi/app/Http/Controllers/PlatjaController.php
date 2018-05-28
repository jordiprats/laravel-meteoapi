<?php

namespace App\Http\Controllers;

use App\Platja;
use Illuminate\Http\Request;

class PlatjaController extends Controller
{
  public static function getPlatges()
  {
    $c = curl_init('http://meteo.cat/prediccio/platges');
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
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

  public static function fetchPlatja($platja_slug)
  {
    //http://meteo.cat/prediccio/platges/tossa-de-mar-de-la-mar-menuda
    $c = curl_init('http://meteo.cat/prediccio/platges/'.$platja_slug);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt(... other options you want...)

    $html = curl_exec($c);

    if (curl_error($c))
        die(curl_error($c));

    // Get the status code
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);

    curl_close($c);

    preg_match('/\bdades: (.*),/', $html, $matches, PREG_OFFSET_CAPTURE);

    $prediccio = json_decode($matches[1][0]);

    foreach ($prediccio as $data_prediccio)
    {
      print_r($data_prediccio);
    }
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //TODO: caching
    $c = curl_init('http://meteo.cat/prediccio/platges');
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    //curl_setopt(... other options you want...)

    $html = curl_exec($c);

    if (curl_error($c))
        die(curl_error($c));

    // Get the status code
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);

    curl_close($c);

    preg_match('/metadadesPuntsPlatges: (.*),/', $html, $matches, PREG_OFFSET_CAPTURE);

    return [ 'platges' => json_decode($matches[1][0]) ];
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
   * @param  \App\Platja  $platja
   * @return \Illuminate\Http\Response
   */
  public function show($platja_slug)
  {
    //http://meteo.cat/prediccio/platges/tossa-de-mar-de-la-mar-menuda
    //TODO: caching
    $c = curl_init('http://meteo.cat/prediccio/platges/'.$platja_slug);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    //curl_setopt(... other options you want...)

    $html = curl_exec($c);

    if (curl_error($c))
        die(curl_error($c));

    // Get the status code
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);

    curl_close($c);

    preg_match('/\bdades: (.*),/', $html, $matches, PREG_OFFSET_CAPTURE);

    return [ 'prediccio' => json_decode($matches[1][0]) ];
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Platja  $platja
   * @return \Illuminate\Http\Response
   */
  public function edit(Platja $platja)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Platja  $platja
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Platja $platja)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Platja  $platja
   * @return \Illuminate\Http\Response
   */
  public function destroy(Platja $platja)
  {
    //
  }
}
