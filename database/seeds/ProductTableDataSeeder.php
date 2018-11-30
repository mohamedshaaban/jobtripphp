<?php

  

use Illuminate\Database\Seeder;

use App\Product;

  

class ProductTableDataSeeder extends Seeder

{

    /**

     * Run the database seeds.

     *

     * @return void

     */

    public function run()

    {

        for ($i=0; $i < 3; $i++) { 

	    	Product::create([

	            'name' => str_random(8),

	            'detail' => str_random(12).'@mail.com',


	        ]);

    	}

    }

}