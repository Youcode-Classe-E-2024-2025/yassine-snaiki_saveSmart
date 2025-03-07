<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MonthlySummary;
use App\Models\Transaction;
use Carbon\Carbon;

class SummaryController extends Controller
{
    public function index()
    {
        $user = Auth::user();


        $summaries = MonthlySummary::where('user_id', $user->id)
            ->orderBy('period', 'desc')
            ->get();

        $profileIds = $user->profiles->pluck('id');
        $transactions = Transaction::whereIn('profile_id', $profileIds)
            ->orderBy('created_at', 'desc')
            ->get();

        // Prepare data for Chart.js
        $chartLabels = [];
        $chartData = [];

        foreach ($summaries as $summary) {
        
            $date = Carbon::parse($summary->period);
            $chartLabels[] = $date->format('F Y');
            $chartData[] = $summary->saved_amount;
        }

        return view('summaries.index', compact('summaries', 'transactions', 'chartLabels', 'chartData'));
    }
}
