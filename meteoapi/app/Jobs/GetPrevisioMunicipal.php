<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PrevisioController;
use App\Municipi;
use App\Previsio;

class GetPrevisioMunicipal implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $municipi_slug;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($municipi_slug)
  {
    $this->municipi_slug = $municipi_slug;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $municipi=Municipi::where(['slug' => $this->municipi_slug])->first();

    if($municipi)
    {
      $fetched_previsio = PrevisioController::getPrevisioMunicipal($municipi->id);

      // TODO: data_previsio
      // [1] => stdClass Object
      //     (
      //         [dies] => Array
      //             (
      //                 [0] => DS. 9
      //                 [1] => DG. 10
      //                 [2] => DL. 11
      //                 [3] => DT. 12
      //                 [4] => DC. 13
      //                 [5] => DJ. 14
      //             )
      // 'sun' | 'mon' | 'tue' | 'wed' | 'thu' | 'fri' | 'sat'
      // DL / mon, DT / tue, DC / wed, DJ / thu, DV / fri, DS / sat, DG / sun
      $traductor_dies= [
        'DL' => 'mon',
        'DT' => 'tue',
        'DC' => 'wed',
        'DJ' => 'thu',
        'DV' => 'fri',
        'DS' => 'sat',
        'DG' => 'sun',
      ];

      foreach($fetched_previsio->dies as $i => $dia)
      {
        $fetched_dia=new \DateTime("next ".$traductor_dies[$dia[0].$dia[1]]);

        $previsio = Previsio::where(['municipi_id' => $municipi->id, 'data_previsio' => $fetched_dia, 'tipus' => 2])->first();

        if(!$previsio)
        {
          $previsio = Previsio::create([
            'municipi_id' => $municipi->id,
            'tipus'             => 2,
            'data_previsio'     => $fetched_dia,
            'temperatura_max' => $fetched_previsio->tmax[$i],
            'temperatura_min' => $fetched_previsio->tmin[$i],
            'probabilitat_precipitacio' => $fetched_previsio->pprec[$i],
          ]);
        }
        else
        {
          $previsio->save();
        }
      }
    }
    else
      Log::info("municipi NOT FOUND: ".$this->municipi_slug);

  }
}
