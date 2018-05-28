<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Platja;

class ShowPlatgesCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'meteoapi:showplatges {--slug}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'llistat de platges';

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
    foreach(Platja::orderBy('slug', 'ASC')->get() as $platja)
    {
      if($this->option('slug'))
        print($platja->slug."\n");
      else
        print($platja->nom."\n");
    }
  }
}
