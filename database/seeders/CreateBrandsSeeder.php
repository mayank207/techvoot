<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class CreateBrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name'=>'addidas'],
            ['name'=>'puma'],
            ['name'=>'Kalyan'],
            ['name'=>'Titan'],
            ['name'=>'Leggits'],
            ['name'=>'HP'],
            ['name'=>'Dell'],
            ['name'=>'Assus'],
            ['name'=>'Damsung'],
            ['name'=>'Lenovo'],
            ['name'=>'fastrack'],
            ['name'=>'intel'],

        ];
        foreach ($data as $item) {
            Brand::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}
