<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Platja;
use App\Municipi;


class InitDBCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'meteoapi:initdb';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'init db';

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
    if(Municipi::count()==0)
    {
      try
      {
        Log::info("scheduled job GetMunicipis");
        dispatch(new GetMunicipis());

        if(Platja::count()==0)
        {
          try
          {
            Log::info("scheduled job GetPlatges");
            dispatch(new GetPlatges());
          }
          catch(\Exception $e)
          {
            Log::info("-_(._.)_-");
            Log::info($e);
          }
        }
      }
      catch(\Exception $e)
      {
        Log::info("-_(._.)_-");
        Log::info($e);
      }
    }
  }
}
