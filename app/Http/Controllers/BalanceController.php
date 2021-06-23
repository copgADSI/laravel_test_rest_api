<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function show(Request $request)
    {
        $account_id = $request->input('account_id');//Se optiene el id por el método request
        $account = Account::findOrFail($account_id); //Buscamos el id y si no existe producimos un fallo
        return $account->balance; //Si se encuentra el id, retornamos su balance
    }
}
