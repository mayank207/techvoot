<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class CreateProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $a =0;
        while ($a <= 10) {
            Product::create([
                'name' => $faker->unique()->word,
                'price' => $faker->numberBetween($min = 1500, $max = 6000),
                'brand_id' => $faker->numberBetween($min = 1, $max = 10),
            ]);
            $a++;
        }

    }
}
