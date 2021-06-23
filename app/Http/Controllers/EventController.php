<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function store(Request $request)
    {
        //Event create
        if ($request->input('type') === 'deposit') { //Tipo deposito
            return $this->deposit(
                $request->input('destination'),
                $request->input('amount')
            );   
        }else if ($request->input('type') === 'withdraw') {
            return  $this->withdraw(
                $request->input('origin'),
                $request->input('amount')
            );
        }else if ($request->input('type') === 'transfer') {
            return $this->transfer(
                $request->input('origin'),
                $request->input('amount'),
                $request->input('destination')
            );
        }
    }
   
    public function deposit($destination,$amount)
    {
        $account = Account::firstOrCreate([
            'id' => $destination
        ]); //Buscar cuenta existento, si no  crearla

        $account->balance += $amount;
        $account->save();

        return response()->json([
            'destination'=> [
                'id' => $account->id,
                'balance' =>  $account->balance
            ]
        ],201);
    }
    public function withdraw($origin,$amount)
    {

        $account = Account::findOrFail($origin);   
        $account->balance -= $amount;
        $account->save();

        return response()->json([
            'origin'=> [
                'id' => $account->id,
                'balance' =>  $account->balance
            ]
        ],201);
    }
    public function transfer($origin,$amount,$destination)
    {
        $account_Origin = Account::findOrFail($origin);
        $account_Destination = Account::firstOrCreate([
            'id' =>$destination
        ]);
        DB::transaction(function () use($account_Origin,$amount,$account_Destination) {
            $account_Origin->balance  -= $amount;
            $account_Destination->balance += $amount;
            $account_Origin->save();
            $account_Destination->save();
        });
        return response()->json([
           'origin' => [
                'id' => $account_Origin->id,
                'balance' =>  $account_Origin->balance,
            ],
            'destination' =>[
                'id' =>$account_Destination->id,
                'balance' => $account_Destination->balance
            ]
         
        ],201);
    }
}
