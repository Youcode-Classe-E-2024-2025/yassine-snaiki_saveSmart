<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create(Request $request){
        $validated = $request->validate([
            'amount'=>"required|numeric",
            "category_id"=>"required|string",
            "profile_id" => "required|string"
        ]);

        if(session('profile_authenticated') === $validated['profile_id']){

            Transaction::create($validated);
        }
        return back();

    }
}
