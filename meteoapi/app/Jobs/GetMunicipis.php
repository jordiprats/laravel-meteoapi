<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\MunicipiController;
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
    Log::info("running job GetMunicipis");
    $fetched_municipis = MunicipiController::getMunicipis();

    foreach($fetched_municipis as $fetched_municipi)
    {
      $municipi = Municipi::where(['id' => $fetched_municipi->codi])->first();
      $comarca = Comarca::where(['id' => $fetched_municipi->comarca->codi])->first();

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
          'id'   => $fetched_municipi->comarca->codi,
          'nom'  => $fetched_municipi->comarca->nom,
          'slug' => str_slug($fetched_municipi->comarca->nom, '-'),
        ]);
      }
      else
      {
        $comarca->nom  = $fetched_municipi->comarca->nom;
        $comarca->id   = $fetched_municipi->comarca->codi;
        $comarca->slug = str_slug($fetched_municipi->comarca->nom, '-');

        $comarca->save();
      }

      if(!$fetched_municipi->slug)
        $municipi_slug=str_slug($fetched_municipi->nom, "-");
      else
        $municipi_slug=$fetched_municipi->slug;

      if(!$municipi)
      {
        $municipi = Municipi::create([
          'id'             => $fetched_municipi->codi,
          'nom'            => $fetched_municipi->nom,
          'nom_strcmp'     => MunicipiController::toStrCmp($fetched_municipi->nom),
          'slug'           => $municipi_slug,
          'latitude'       => $fetched_municipi->coordenades->latitud,
          'latitude_ceil'  => intval(ceil($fetched_municipi->coordenades->latitud)),
          'longitude'      => $fetched_municipi->coordenades->longitud,
          'longitude_ceil' => intval(ceil($fetched_municipi->coordenades->longitud)),
          'comarca_id'     => $comarca->id,
        ]);
      }
      else
      {
        $municipi->id               = $fetched_municipi->codi;
        $municipi->nom              = $fetched_municipi->nom;
        $municipi->nom_strcmp       = MunicipiController::toStrCmp($fetched_municipi->nom);
        $municipi->slug             = $municipi_slug;
        $municipi->latitude         = $fetched_municipi->coordenades->latitud;
        $municipi->latitude_ceil    = intval(ceil($fetched_municipi->coordenades->latitud));
        $municipi->longitude        = $fetched_municipi->coordenades->longitud;
        $municipi->longitude_ceil   = intval(ceil($fetched_municipi->coordenades->longitud));
        $municipi->comarca_id       = $comarca->id;

        $municipi->save();
      }
    }
  }
}
