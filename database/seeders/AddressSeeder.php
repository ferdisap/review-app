<?php

namespace Database\Seeders;

use App\Http\Controllers\AddressController;
use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Address::factory(1)->create();
    $filling = new AddressController();
    $filling->fillIndexes();
  }
}
