<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PrevisioController;
use App\Platja;
use App\Previsio;

class GetPrevisioPlatja implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $platja_slug;
  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($platja_slug)
  {
    $this->platja_slug=$platja_slug;
  }

  public static function variablesPrevisio2array($data)
  {
    if (is_array($data) || is_object($data))
    {
      $result = array();
      foreach ($data as $num => $item)
      {
        $result[$item->nom]=$item->valor;
      }
      return $result;
    }
    return $data;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    Log::info("running job GetPrevisioPlatja: ".$this->platja_slug);

    $platja=Platja::where(['slug' => $this->platja_slug])->first();

    if($platja)
    {
      $previsions = PrevisioController::getPrevisioPlatja($this->platja_slug);

      foreach ($previsions as $fetched_previsio)
      {
        $variables = GetPrevisioPlatja::variablesPrevisio2array($fetched_previsio->variables);

        //print_r($variables);

        $previsio = Previsio::where(['platja_id' => $platja->id, 'data_previsio' => $fetched_previsio->data])->first();

        if(!$previsio)
        {
          $previsio = Previsio::create([
            'platja_id' => $platja->id,
            'data_previsio' => gmdate("Y-m-d H:i:s", strtotime($fetched_previsio->data)),
            'temperatura' => floatval($variables['temperatura']),
            'humitat_relativa' => floatval($variables['humitat_relativa']),
            'velocitat_vent' => floatval($variables['velocitat_vent']),
            'direccio_vent' => floatval($variables['direccio_vent']),
            'estat_cel' => $variables['estat_cel'],
            'altura_ona' => floatval($variables['altura_ona']),
            'direccio_ona' => floatval($variables['direccio_ona']),
            'temperatura_aigua' => floatval($variables['temperatura_aigua']),
            'uvi_maxim' => $variables['uvi_maxim'],
            'uvi_previst' => $variables['uvi_previst'],
          ]);
        }
        else
        {
          $previsio->temperatura = floatval($variables['temperatura']);
          $previsio->humitat_relativa = floatval($variables['humitat_relativa']);
          $previsio->velocitat_vent = floatval($variables['velocitat_vent']);
          $previsio->direccio_vent = floatval($variables['direccio_vent']);
          $previsio->estat_cel = $variables['estat_cel'];
          $previsio->altura_ona = floatval($variables['altura_ona']);
          $previsio->direccio_ona = floatval($variables['direccio_ona']);
          $previsio->temperatura_aigua = floatval($variables['temperatura_aigua']);
          $previsio->uvi_maxim = $variables['uvi_maxim'];
          $previsio->uvi_previst = $variables['uvi_previst'];

          $previsio->save();
        }
      }
    }
    else
      Log::info("NOT FOUND: ".$this->platja_slug);
  }
}
