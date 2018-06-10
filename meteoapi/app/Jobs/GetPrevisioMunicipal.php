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
      $previsions = PrevisioController::getPrevisioMunicipal($municipi->id);

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

      Log::info(print_r($previsions));
      foreach ($previsions as $fetched_previsio)
      {
        // echo gmdate('F j, Y', strtotime('next fri'));

        //var_dump($fetched_previsio->dies);

        //new \DateTime(

        //$previsio = Previsio::where(['municipi_id' => $municipi->id, 'data_previsio' => new \DateTime($fetched_previsio->data)])->first();
      }
    }
    else
      Log::info("municipi NOT FOUND: ".$this->municipi_slug);

  }
}
