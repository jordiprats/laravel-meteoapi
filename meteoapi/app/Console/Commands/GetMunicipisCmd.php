<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\MunicipiController;
use App\Jobs\GetMunicipis;

class GetMunicipisCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'meteoapi:getmunicipis';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'get municipis';

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
    try
    {
      Log::info("scheduled job GetMunicipis");
      dispatch(new GetMunicipis());
    }
    catch(\Exception $e)
    {
      Log::info("-_(._.)_-");
      Log::info($e);
    }
  }
}
