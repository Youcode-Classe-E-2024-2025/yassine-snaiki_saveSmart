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
        // Budget mensuel fixe
        $monthlyBudget = 5000;

        // On définit la "période" actuelle sous forme de minute (ex: "2025-02-27 14:50")
        $currentPeriod = Carbon::now()->format('Y-m-d H:i');

        // Récupérer tous les utilisateurs avec leurs profils et transactions associés
        $users = User::with('profiles.transactions')->get();


        foreach ($users as $user) {
            $totalExpenses = 0;

            // Pour chaque profil de l'utilisateur, on additionne les dépenses de la dernière minute
            foreach ($user->profiles as $profile) {
                $expenses = $profile->transactions()
                    ->where('created_at', '>=', Carbon::now()->subMinute())
                    ->sum('amount');
                $totalExpenses += $expenses;
            }

            // Calculer le montant épargné (si dépenses > budget, on considère 0)
            $savedAmount = $monthlyBudget - $totalExpenses;
            if ($savedAmount < 0) {
                $savedAmount = 0;
            }

            // Stocker le résumé mensuel
            MonthlySummary::create([
                'user_id'      => $user->id,
                'period'       => $currentPeriod,
                'saved_amount' => $savedAmount,
            ]);

            // (Optionnel) Vous pouvez effacer ou archiver les transactions de la période écoulée si nécessaire
            // foreach ($user->profiles as $profile) {
            //     $profile->transactions()->where('created_at', '<', Carbon::now()->subMinute())->delete();
            // }
        }

        $this->info('Réinitialisation du budget simulée pour la période ' . $currentPeriod);
    }
}
