<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;



class TransactionExport implements FromCollection, WithHeadings
{

    private $idClient;
    private $filtros;

    public function __construct($idClient, $filtros = [])
    {
        $this->idClient = $idClient;
        $this->filtros   = $filtros;

    }

    public function headings():array
    {
        return [
            "id",
            "type",
            "amount",
            "created_at"
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user          = new User();
        $transaction   = new Transaction();

        $objUser = $user->where('id', $this->idClient)->get();

        if (count($objUser) < 1) {
            return response()->json(['status'=>'error', 'message'=>'cliente nao encontrado'], 401);
        }
        $date = $objUser[0]->created_at;
        $initial = 0;
        $end = \Carbon\Carbon::now();
        foreach($this->filtros as $key=>$filtro){
            if ($key == 'days') {

                $day = (int)$filtro;
                $date = \Carbon\Carbon::now()->addDays(-$day);

            }
            if ($key == 'period') {

                $initial = \Carbon\Carbon::parse($filtro.'-01');
                $end = \Carbon\Carbon::parse($filtro.'-01')->addMonth(1);

                $date = $objUser[0]->created_at;

            }                
        }
    
        $objTransaction = $transaction
                            ->whereBetween('created_at', [$initial, $end])
                            ->where('created_at', '>', $date)
                            ->where('id_client', $this->idClient)
                            ->select('id', 'type', 'amount', 'created_at')
                            ->orderBy('created_at', 'DESC')->get();

        return $objTransaction;

        foreach($objTransaction as &$trans) {

            $trans->amount = number_format($trans->amount, 2, ',', '.');
        }
        
        return collect($objTransaction);
    }
}
