<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\MonthlySummary;
use Carbon\Carbon;

class ResetMonthlyBudget extends Command
{
    protected $signature = 'budget:reset';
    protected $description = 'Simule la réinitialisation mensuelle du budget (1 minute = 1 mois) pour chaque utilisateur';

    public function handle()
    {
        $lastPeriodStart = Carbon::now()->subMinute()->startOfMinute();
        $lastPeriodEnd = Carbon::now()->subMinute()->endOfMinute();
        $currentPeriod = Carbon::now()->format('Y-m-d H:i');
        $users = User::with('profiles.transactions')->get();

        foreach ($users as $user) {
            $monthlyBudget = $user->profiles()->sum('income');
            $totalExpenses = 0;

            foreach ($user->profiles as $profile) {
                $expenses = $profile->transactions()
                    ->whereBetween('created_at', [$lastPeriodStart, $lastPeriodEnd])
                    ->sum('amount');

                $totalExpenses += $expenses;
            }

            $savedAmount = max($monthlyBudget - $totalExpenses, 0);

            $currentGoal = $user->goals()->where('checked', false)->first();

            if ($currentGoal) { // Prevent calling methods on null
                $amount = $currentGoal->amount;
                $progress = $currentGoal->progress;
                $progress += $savedAmount;
                $progress = min($progress, $amount);
                $checked = $progress >= $amount;

                $currentGoal->update([
                    'progress' => $progress,
                    'checked' => $checked
                ]);
            }

            MonthlySummary::create([
                'user_id' => $user->id,
                'period' => $currentPeriod,
                'saved_amount' => $savedAmount,
            ]);
        }

        $this->info('Réinitialisation du budget simulée pour la période ' . $currentPeriod);
    }
}
