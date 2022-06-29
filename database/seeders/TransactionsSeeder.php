<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::insert([
            ['id'=>1, 'id_client'=> 1, 'type'=> 'credito', 'amount'=> '130.30', 'created_at'=>'2022-05-15', 'updated_at'=> now()],
            ['id'=>2, 'id_client'=> 1, 'type'=> 'credito', 'amount'=> '25.30', 'created_at'=>'2022-06-15', 'updated_at'=> now()],
            ['id'=>3, 'id_client'=> 1, 'type'=> 'debito', 'amount'=> '11.80', 'created_at'=>'2022-06-25', 'updated_at'=> now()],
            ['id'=>4, 'id_client'=> 1, 'type'=> 'estorno', 'amount'=> '11.80', 'created_at'=>'2022-06-26', 'updated_at'=> now()],
            ['id'=>5, 'id_client'=> 2, 'type'=> 'credito', 'amount'=> '299.90', 'created_at'=>'2022-06-18', 'updated_at'=> now()],
            ['id'=>6, 'id_client'=> 2, 'type'=> 'debito', 'amount'=> '19.90', 'created_at'=>'2022-06-10', 'updated_at'=> now()],
            ['id'=>7, 'id_client'=> 3, 'type'=> 'credito', 'amount'=> '139.80', 'created_at'=>'2022-05-25', 'updated_at'=> now()],
            ['id'=>8, 'id_client'=> 3, 'type'=> 'credito', 'amount'=> '59.60', 'created_at'=>'2022-05-28', 'updated_at'=> now()],
            ['id'=>9, 'id_client'=> 1, 'type'=> 'estorno', 'amount'=> '130.30', 'created_at'=>'2022-05-16', 'updated_at'=> now()],
        ]);
    }
}
