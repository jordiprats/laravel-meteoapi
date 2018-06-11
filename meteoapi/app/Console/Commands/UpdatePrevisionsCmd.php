<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\GetPrevisioPlatja;
use App\Jobs\GetPrevisioMunicipal;
use App\Previsio;
use App\Platja;
use App\Municipi;

class UpdatePrevisionsCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'meteoapi:updateprevisions';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Actualitza previsions existents';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    // update previsions de platjes
    foreach(Previsio::distinct()->get(['platja_id']) as $platja_amb_previsio)
    {
      //
      $platja=Platja::where(['id' => $platja_amb_previsio->platja_id])->first();

      if($platja)
      {
        try
        {
          Log::info("scheduled job GetPrevisioPlatja: ".$platja->slug);
          dispatch(new GetPrevisioPlatja($platja->slug));
        }
        catch(\Exception $e)
        {
          Log::info("-_(._.)_-");
          Log::info($e);
        }
      }
    }

    // update previsions municipals
    foreach(Previsio::distinct()->get(['municipi_id']) as $municipi_amb_previsio)
    {
      $municipi=Municipi::where(['id' => $municipi_amb_previsio->municipi_id])->first();

      if($municipi)
      {
        try
        {
          Log::info("scheduled job GetPrevisioMunicipal: ".$municipi->slug);
          dispatch(new GetPrevisioMunicipal($municipi->slug));
        }
        catch(\Exception $e)
        {
          Log::info("-_(._.)_-");
          Log::info($e);
        }
      }
    }

  }
}
