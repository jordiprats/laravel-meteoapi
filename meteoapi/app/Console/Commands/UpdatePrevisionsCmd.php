<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\GetPrevisioPlatja;
use App\Previsio;
use App\Platja;

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

  }
}
