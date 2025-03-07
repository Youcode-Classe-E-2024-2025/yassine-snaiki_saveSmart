<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create(Request $request){
        $validated = $request->validate([
            'amount'=>"required|numeric",
            "category_id"=>"required|string",
            "confirmed" => 'numeric'
        ]);
        $periodStart = Carbon::now()->startOfMinute();
        $periodEnd = Carbon::now()->endOfMinute();
        $isExceeded = false;
        $isIncomeExceeded = false;
       if($validated['confirmed'] === '0') {
           $totalIncome = Auth::user()->profiles()->sum('income');
           $totalExpense = 0;
           foreach (Auth::user()->profiles as $pr) {
               $expenses = $pr->transactions()
               ->whereBetween('created_at',[$periodStart,$periodEnd])
               ->sum('amount');
               $totalExpense += $expenses;
            }
            if($validated['amount'] + $totalExpense > $totalIncome * 0.8)
            $isExceeded = true;
        if($validated['amount'] + $totalExpense > $totalIncome)
        $isIncomeExceeded = true;
        

       }

        if($isExceeded) return back()->with(['isExceeded'=>$isIncomeExceeded ? 'You re exceeding the income are you sure?' : ($isExceeded ? 'you re using the 20% saving are you sure?' : null),'validated'=>$validated]);

        $validated['profile_id'] = session('profile_authenticated');

        Transaction::create($validated);
        return back();
    }
}
