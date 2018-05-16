<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PlatjaController;
use App\Jobs\GetPlatges;

class GetPlatgesCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'meteoapi:getplatges';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'get platges';

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
      Log::info("job GetPlatges");
      dispatch(new GetPlatges());
    }
    catch(\Exception $e)
    {
      Log::info("-_(._.)_-");
      Log::info($e);
    }
  }
}
