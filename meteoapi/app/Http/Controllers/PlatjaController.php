<?php

namespace App\Http\Controllers;

use App\Platja;
use Illuminate\Http\Request;

class PlatjaController extends Controller
{
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
  public function show(Platja $platja)
  {
    //
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
