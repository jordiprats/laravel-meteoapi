<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrevisioController extends Controller
{
  public static function getPrevisioPlatja($platja_slug)
  {
    // http://meteo.cat/prediccio/platges/tossa-de-mar-de-la-mar-menuda
    $c = curl_init('http://meteo.cat/prediccio/platges/'.$platja_slug);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) Gecko/20100101 Firefox/59.0');
    //curl_setopt(... other options you want...)

    $html = curl_exec($c);

    if (curl_error($c))
        die(curl_error($c));

    // Get the status code
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);

    curl_close($c);

    // preg_match('/dades: (.*),/', $html, $matches, PREG_OFFSET_CAPTURE);
    preg_match('/\bdades: (.*),/', $html, $matches, PREG_OFFSET_CAPTURE);

    if($matches[1][0])
    {
      return json_decode($matches[1][0]);
    }
    else
      return null;
  }
}
