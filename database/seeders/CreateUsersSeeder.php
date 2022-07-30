<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'name'=>'Admin',
               'email'=>'admin@techvoot.com',
                'is_admin'=>'1',
               'password'=> bcrypt('tech@123'),
            ],
            [
               'name'=>'mayank',
               'email'=>'mayank@techvoot.com',
                'is_admin'=>'0',
               'password'=> bcrypt('tech@123'),
            ],
        ];
  
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
