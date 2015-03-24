<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

 
class DTSeed extends Seeder {
 
  public function run()
  {
 	$datatype = App\DataType::create(array(
	'name'=>'Unassigned'
	)); 
  }
 
}
