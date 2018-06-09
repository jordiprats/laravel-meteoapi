<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrevisioController extends Controller
{
  public static function getPrevisioMunicipal($municipi_id)
  {
    //080193
    $str_munucipi_id=sprintf("%06d", $municipi_id);

    //http://www.meteo.cat/prediccio/municipal/080193
    $c = curl_init('http://www.meteo.cat/prediccio/municipal/'.$str_munucipi_id);
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
    preg_match('/Meteocat.graficaMunicipal.renderitzarGrafica\((([^\)]*|\)*)*)\);/m', $html, $matches, PREG_OFFSET_CAPTURE);

    // print_r($matches);

    if($matches[1][0])
    {
      $previsio_json=preg_replace('/\/\/[a-z]*/', '', $matches[1][0]);
      $previsio_json=preg_replace('/\'/', '"', $previsio_json);
      $previsio_json=preg_replace('/\\by\\b/', '"y"', $previsio_json);
      $previsio_json=preg_replace('/\\bmarker\\b/', '"marker"', $previsio_json);
      $previsio_json=preg_replace('/\\bsymbol\\b/', '"symbol"', $previsio_json);
      $previsio_json=preg_replace('/\\bgrafica-municipal\\b/', 'graficamunicipal', $previsio_json);
      $previsio_json='['.$previsio_json.']';
      return json_decode($previsio_json);
    }
    else
      return null;
  }

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
