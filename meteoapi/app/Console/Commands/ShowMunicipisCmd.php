<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Municipi;

class ShowMunicipisCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'meteoapi:showmunicipis {--slug}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'llistat de municipis';

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
    foreach(Municipi::all()::orderBy('nom_strcmp', 'DESC') as $municipi)
    {
      print($municipi->nom."\n");
    }
  }
}
