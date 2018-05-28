<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Comarca;

class ShowComarquesCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'meteoapi:showcomarques {--slug}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'llistat de comarques';

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
    foreach(Comarca::orderBy('nom', 'ASC')->get() as $comarca)
    {
      if($this->option('slug'))
        print($comarca->slug."\n");
      else
        print($comarca->nom."\n");
    }
  }
}
