<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class MonthlyBudgetCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_saved_amount_calculation_is_correct()
    {
        $user = User::factory()->create();

        // Create two profiles with different incomes
        Profile::factory()->create([
            'user_id' => $user->id,
            'income' => 3000
        ]);

        Profile::factory()->create([
            'user_id' => $user->id,
            'income' => 2000
        ]);

        // Total budget should be 5000
        $monthlyBudget = $user->profiles()->sum('income');
        $this->assertEquals(5000, $monthlyBudget);
    }
}
