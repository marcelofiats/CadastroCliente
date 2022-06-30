<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function create(UsersRequest $usersRequest)
    {
        $usersRequest->validated();

        $age = \Carbon\Carbon::parse($usersRequest['birthday'])->age;

        if ($age < 18) {
            return response()->json(['status'=>'error', 'message'=>'pessoa deve ter mais de 18 anos'], 401);
        }

        $user = new User();
        $user->name = $usersRequest['name'];
        $user->email = $usersRequest['email'];
        $user->birthday = date('Y-m-d', strtotime($usersRequest['birthday']));

        $user->save();
        
        return response()->json(['status'=>'success', 'message'=>'Cliente Cadastrado com sucesso'], 200);
    }

    public function getAll() 
    {
        $user = new User();
        return response()->json($user->orderBy('created_at', 'DESC')->get(), 200);
    }

    public function getById(Request $request)
    {
        if ( !isset($request->id)) {
            return response()->json(['status'=>'error', 'message'=>'id do cliente nao informado'], 401);
        }
        $user = new User();

        $objUser = $user->where('id',$request->id)->get();

        if (count($objUser) < 1) {
            return response()->json(['status'=>'error', 'message'=>'cliente nao encontrado'], 401);
        }

        return response()->json($objUser[0], 200);
    }

    public function delete(Request $request) 
    {
        $user = new User();

        if ( !isset($request->id)) {
            return response()->json(['status'=>'error', 'message'=>'id do cliente nao informado'], 401);
        }

        if (count(Transaction::where('id_client', $request->id)->get()) > 0) {
            return response()->json(['status'=>'error', 'message'=>'cliente não pode ser excluido, consta trasacao'], 401);
        }

        $objUser = $user->where('id',$request->id)->get();

        if (count($objUser) < 1) {
            return response()->json(['status'=>'error', 'message'=>'cliente nao encontrado'], 401);
        }

        try{
            $user->destroy($request->id);
        }
        catch(\Exception $ex){
            return response()->json(['status'=>'error', 'message'=>$ex->getMessage()], 401);
        }
        

        return response()->json(['status'=>'success', 'message'=>'Cliente E-mail: ' . $objUser[0]->email.', deletado com sucesso'], 200);
        
    }

    public function alterBalance(Request $request) 
    {
        if ( !isset($request->id_client)) {
            return response()->json(['status'=>'error', 'message'=>'id do cliente nao informado'], 401);
        }
        if (!isset($request->value) || $request->value < 0) {
            return response()->json(['status'=>'error', 'message'=>'Valor nao existe ou e menor que 0'], 401);
        }

        $user = new User();

        $objUser = $user->where('id',$request->id_client)->get();

        if (count($objUser) < 1) {
            return response()->json(['status'=>'error', 'message'=>'cliente nao encontrado'], 401);
        }

        $objUser = $objUser->first();
        
        $objUser->initial_balance = (float)$request->value;

        $objUser->save();

        return response()->json(['status'=>'success', 'message'=>'Cliente E-mail: ' . $objUser->email.', teve seu saldo inicial alterado'], 200);
    }

}