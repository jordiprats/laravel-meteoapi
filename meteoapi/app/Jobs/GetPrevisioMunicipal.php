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

      // Log::info(print_r($previsions,true));
      foreach ($previsions as $fetched_previsio)
      {
        // TODO: data_previsio
        $previsio = Previsio::where(['municipi_id' => $municipi->id, 'data_previsio' => new \DateTime($fetched_previsio->data)])->first();
      }
    }
    else
      Log::info("municipi NOT FOUND: ".$this->municipi_slug);

  }
}
