<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\GetPrevisioPlatja;

class GetPrevisioPlatjaCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'meteoapi:getprevisioplatja {platja_slug}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'get Previso Platja';

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
    $platja_slug=$this->argument('platja_slug');

    try
    {
      Log::info("scheduled job GetPrevisioPlatja: ".$platja_slug);
      dispatch(new GetPrevisioPlatja($platja_slug));
    }
    catch(\Exception $e)
    {
      Log::info("-_(._.)_-");
      Log::info($e);
    }
  }
}
