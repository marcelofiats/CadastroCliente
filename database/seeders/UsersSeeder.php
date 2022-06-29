<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            ['id'=>1, 'name'=> 'Marcelo Fiats','email'=> 'marcelo.fiats@gmail.com', 'birthday'=> '1987-02-19', 'created_at'=>'2022-05-10', 'updated_at' => now()],
            ['id'=>2, 'name'=> 'Natalia Macedo','email'=> 'natalia@gmail.com', 'birthday'=> '1992-07-13', 'created_at'=>'2022-05-15', 'updated_at' => now()],
            ['id'=>3, 'name'=> 'Joao Lopes','email'=> 'joao.lopes@gmail.com', 'birthday'=> '1993-12-13', 'created_at'=>'2022-05-20', 'updated_at' => now()]
        ]);
    }
}
