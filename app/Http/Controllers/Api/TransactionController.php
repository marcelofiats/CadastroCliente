<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\File;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\TransactionExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\TransactionRequest;
use DateTime;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionController extends Controller
{
    public function create(TransactionRequest $request)
    {
        
        $transaction = new Transaction();

        $transaction->create($request->all());

        return response()->json(['status'=>'success', 'message'=>'Transacao criada com sucesso'], 200);

    }

    public function getByClient(Request $request)
    {
        if ( !isset($request->id_client)) {
            return response()->json(['status'=>'error', 'message'=>'id do cliente nao informado'], 401);
        }

        $user          = new User();
        $transaction   = new Transaction();
        $idClient = $request->id_client;

        $objUser = $user->where('id', $idClient)->get();

        if (count($objUser) < 1) {
            return response()->json(['status'=>'error', 'message'=>'cliente nao encontrado'], 401);
        }

        $objTransactionClient = $transaction->where('id_client', $idClient)->orderBy('created_at', 'DESC')->get();

        if (count($objTransactionClient) < 1) {
            $objTransactionClient = 'Sem transacoes';
        }
        $result = $objUser[0];
        $result['transactions'] = $objTransactionClient;

        return response()->json($result, 200);
    }

    public function getById(Request $request) 
    {

        if ( !isset($request->id)) {
            return response()->json(['status'=>'error', 'message'=>'id da transacao nao informado'], 401);
        }

        $transaction = new Transaction();
        $objTransactionClient = $transaction->where('id', $request->id)->get();

        if (count($objTransactionClient) < 1) {
            return response()->json(['status'=>'error', 'message'=>'transacao nao encontrada'], 401);
        }

        return response()->json($objTransactionClient, 200);
    }

    public function cancel(Request $request) 
    {
        if ( !isset($request->id_cliente) || !isset($request->id)) {
            return response()->json(['status'=>'error', 'message'=>'informacoes insuficientes'], 401);
        }

        $transaction = new Transaction();
        $objTransactionClient = $transaction->where('id', $request->id)
                                            ->where('id_client', $request->id_cliente)->get();

        if (count($objTransactionClient) < 1) {
            return response()->json(['status'=>'error', 'message'=>'transacao nao encontrada'], 401);
        }

        $transaction->destroy($request->id);

        return response()->json(['status'=>'success', 'message'=>'Transacao deletada com sucesso'], 200);
    }

    public function extract(Request $request)
    {     
        if ( !isset($request->id_cliente)) {
            return response()->json(['status'=>'error', 'message'=>'id do cliente nao informado'], 401);
        }

        $idClient = $request->id_cliente;

        $filtros = [];

        if (isset($request->period_days)) {
            $filtros['days'] = $request->period_days;
        }

        if (isset($request->period)) {
            $filtros['period'] = $request->period;
        }

        $fileName = 'extract_cliente_'.$idClient.'.xlsx';

        return Excel::download(new TransactionExport($idClient, $filtros), $fileName);
        
    }

    public function balance(Request $request)
    {
        if ( !isset($request->id_client)) {
            return response()->json(['status'=>'error', 'message'=>'id do cliente nao informado'], 401);
        }

        $user = User::where('id', $request->id_client)->get();

        $transaction = new Transaction();
        $objTransactionClient = $transaction->where('id_client', $request->id_client)->get();
        
        $credito = 0;
        $debito = 0;
        $estorno = 0;

        foreach($objTransactionClient as $trans){

            switch($trans->type){
                case 'credito':
                    $credito += (float)$trans->amount;
                    break;
                case 'debito':
                    $debito += (float)$trans->amount;
                    break;
                case 'estorno':
                    $estorno += (float)$trans->amount;
                    break;
                default:
            }

        }

        $total = $credito + $debito + $estorno;

        return response()->json([
            'cliente'=> $user[0],
            'credito'=>number_format($credito, 2, ',', '.'), 
            'debito'=>number_format($debito, 2, ',', '.'), 
            'estorno'=>number_format($estorno, 2, ',', '.'), 
            'total'=>number_format($total, 2, ',', '.')], 
        200);
        
    }
}
