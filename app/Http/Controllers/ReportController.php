<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Goal;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function generateMonthlyReport()
    {
        $lastPeriodStart = Carbon::now()->subMinute()->startOfMinute();
        $lastPeriodEnd = Carbon::now()->subMinute()->endOfMinute();
        $user = Auth::user();
        $profiles = $user->profiles()->with('transactions')->get();
        $totalIncome = $user->profiles()->sum('income');

        $transactions = Transaction::whereIn('profile_id', $profiles->pluck('id'))
            ->whereBetween('created_at',[$lastPeriodStart,$lastPeriodEnd])
            ->get();


           
        $totalExpense = $transactions->sum('amount');
        $savedAmount = $totalIncome - $totalExpense;

        $goal = Goal::where('checked', false)->first();

        $pdf = Pdf::loadView('reports.monthly_report', compact(
            'user', 'profiles', 'transactions', 'totalIncome', 'savedAmount', 'goal', 'lastPeriodStart','lastPeriodEnd'
        ));

        return $pdf->download('Monthly_Report_'.now()->format('F_Y').'.pdf');
    }
}

