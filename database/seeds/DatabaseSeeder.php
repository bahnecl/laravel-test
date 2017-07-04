<?php

use Illuminate\Database\Seeder;
use App\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'title'          => 'Option 1',
            'description'   => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam',
            'image'         => 'assets/images/temp/option-1.jpg',
            'price'         => 0.49,
        ]);

        Product::create([
            'title'          => 'Option 2',
            'description'   => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam',
            'image'         => 'assets/images/temp/option-2.jpg',
            'price'         => 1.49,
        ]);

        Product::create([
            'title'          => 'Option 3',
            'description'   => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam',
            'image'         => 'assets/images/temp/option-3.jpg',
            'price'         => 2.99,
        ]);
    }
}
