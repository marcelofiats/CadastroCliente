<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {        
        return [
            'id_client'=>'required|integer',
            'type'=>[
                'required',
                Rule::in(['credito', 'debito', 'estorno']),
            ],
            'amount'=>'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'id_client.required'=>'Cliente nao informado',
            'id_client.integer'=>'Id do Cliente eve ser um numero inteiro',
            'type.required'=>'Tipo da transacao nao informado',
            'type.in' => 'Tipo de transacao invalido',
            'amount.required'=>'Valor da Transacao nao informado',
            'amount.numeric'=>'Amout deve ser um valor Float'
        ];
    }
}
