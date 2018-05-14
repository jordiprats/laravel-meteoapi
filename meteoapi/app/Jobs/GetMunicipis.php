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
    $fetched_municipis = MunicipiController::getMunicipis();

    foreach($fetched_municipis as $fetched_municipi)
    {
      $municipi = Municipi::where(['meteo_id' => $fetched_municipi->codi])->first();
      $comarca = Comarca::where(['meteo_id' => $fetched_municipi->comarca->codi])->first();

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
          'meteo_id' => $fetched_municipi->comarca->codi,
          'nom'      => $fetched_municipi->comarca->nom,
        ]);
      }
      else
      {
        $comarca->nom = $fetched_municipi->comarca->nom;

        $comarca->commit();
      }

      if(!$municipi)
      {
        $municipi = Municipi::create([
          'meteo_id'  => $fetched_municipi->codi,
          'nom'       => $fetched_municipi->nom,
          'slug'      => $fetched_municipi->slug,
          'latitude'  => $fetched_municipi->coordenades->latitud,
          'longitude' => $fetched_municipi->coordenades->longitud,
        ]);
      }
      else
      {
        $municipi->nom       = $fetched_municipi->nom;
        $municipi->slug      = $fetched_municipi->slug;
        $municipi->latitude  = $fetched_municipi->coordenades->latitud;
        $municipi->longitude = $fetched_municipi->coordenades->longitud;

        $municipi->commit();
      }
    }
  }
}
