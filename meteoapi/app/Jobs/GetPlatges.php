<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PlatjaController;
use App\Municipi;
use App\Platja;

class GetPlatges implements ShouldQueue
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
      Log::info("running job GetPlatges");

      $fetched_platges = PlatjaController::getPlatges();

      foreach($fetched_platges as $fetched_platja)
      {
        $platja = Platja::where(['slug' => $fetched_platja->slug])->first();
        $municipi = Municipi::where(['nom' => $fetched_platja->municipi])->first();

        if(!$municipi)
        {
          try
          {
            Log::info("job GetMunicipis & rerun GetPlatjes");
            dispatch(new GetMunicipis());
            dispatch(new GetPlatges());
          }
          catch(\Exception $e)
          {
            Log::info("-_(._.)_-");
            Log::info($e);
          }
          return;
        }

        // municipi	"Alcanar"
        // nom	"del Marjal"
        // coordenades
        // latitud	40.54525445
        // longitud	0.524413744
        // slug	"alcanar-del-marjal"

        if(!$platja)
        {
          $platja = Platja::create([
            'nom'            => $fetched_platja->nom,
            'slug'           => $fetched_platja->slug,
            'latitude'       => $fetched_platja->coordenades->latitud,
            'latitude_ceil'  => intval(ceil($fetched_platja->coordenades->latitud)),
            'longitude'      => $fetched_platja->coordenades->longitut,
            'longitude_ceil' => intval(ceil($fetched_platja->coordenades->longitut)),
            'municipi_id'    => $municipi->id,
          ]);
        }
        else
        {
          $platja->nom            = $fetched_platja->nom;
          $platja->slug           = $fetched_platja->slug;
          $platja->latitude       = $fetched_platja->coordenades->latitud;
          $platja->latitude_ceil  = intval(ceil($fetched_platja->coordenades->latitud));
          $platja->longitude      = $fetched_platja->coordenades->longitut;
          $platja->longitude_ceil = intval(ceil($fetched_platja->coordenades->longitut));
          $platja->municipi_id    = $municipi->id;

          $platja->commit;
        }

      }
    }
}
