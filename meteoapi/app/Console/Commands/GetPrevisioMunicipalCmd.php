<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\GetPrevisioMunicipal;

class GetPrevisioMunicipalCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'meteoapi:getprevisiomunicipi {municipi_slug}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'obte previsio municipal';

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
    $municipi_slug=$this->argument('municipi_slug');

    try
    {
      Log::info("scheduled job GetPrevisioMunicipal: ".$municipi_slug);
      dispatch(new GetPrevisioMunicipal($municipi_slug));
    }
    catch(\Exception $e)
    {
      Log::info("-_(._.)_-");
      Log::info($e);
    }
  }
}
