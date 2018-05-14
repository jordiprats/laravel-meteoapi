<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Municipi;
use App\Comarca;

class GetMunicipis implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $municipis = MunicipiController::getMunicipis();

    foreach($municipis as $municipi)
    {
      $municipi = Municipi::where(['meteo_id' => $municipi->codi])->first();
      $comarca = Comarca::where(['meteo_id' => $municipi->comarca->codi])->first();

      // stdClass Object
      // (
      //     [codi] => 430521
      //     [variables] =>
      //     [nom] => Xerta
      //     [slug] =>
      //     [coordenades] => stdClass Object
      //         (
      //             [latitud] => 40.906843901591
      //             [longitud] => 0.49069331978944
      //         )
      //
      //     [comarca] => stdClass Object
      //         (
      //             [codi] => 9
      //             [nom] => Baix Ebre
      //         )
      //   )

      if(!$comarca)
      {
        $comarca = Comarca::create([
          'meteo_id' => $municipi->comarca->codi,
          'nom' => $municipi->comarca->nom,
        ]);
      }
      else
      {
        $comarca->nom=$municipi->comarca->nom;

        $comarca->commit();
      }

      if(!$municipi)
      {
        Municipi::create([
          'meteo_id' => $municipi->codi,
          'nom'      => $municipi->nom,
          'slug' => $municipi->slug,
          'latitude' => $municipi->coordenades->latitud,
          'longitude' => $municipi->coordenades->longitud,
        ]);
      }
      else
      {

      }
    }
  }
}
