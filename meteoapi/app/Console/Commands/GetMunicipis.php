<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MunicipiController;

class GetMunicipis extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'get:municipis';

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
    $municipis = MunicipiController::getMunicipis();

    foreach($municipis as $municipi)
    {
      // stdClass Object
      // (
      //     [codi] => 430521
      //     [variables] =>
      //     [nom] => Xerta
      //     [slug] =>
      //     [coordenades] => stdClass Object
      //         (
      //             [latitud] => 40.906843901591
      //             [longitud] => 0.49069331978944
      //         )
      //
      //     [comarca] => stdClass Object
      //         (
      //             [codi] => 9
      //             [nom] => Baix Ebre
      //         )
      //   )

      print_r($municipi);
    }
  }
}
