<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\Transaction;
use App\Models\Goal;
use App\Models\MonthlySummary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ResetMonthlyBudgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_budget_reset_command_creates_monthly_summary()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'income' => 5000
        ]);

        Transaction::factory()->create([
            'profile_id' => $profile->id,
            'amount' => 3000,
            'created_at' => Carbon::now()->subMinute()
        ]);

        $this->artisan('budget:reset')->assertSuccessful();

        $this->assertDatabaseHas('monthly_summaries', [
            'user_id' => $user->id,
            'saved_amount' => 2000
        ]);
    }

    public function test_goal_progress_updates_after_budget_reset()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'income' => 5000
        ]);

        $goal = Goal::factory()->create([
            'user_id' => $user->id,
            'amount' => 6000,
            'progress' => 4000,
            'checked' => false
        ]);

        Transaction::factory()->create([
            'profile_id' => $profile->id,
            'amount' => 3000,
            'created_at' => Carbon::now()->subMinute()
        ]);

        $this->artisan('budget:reset')->assertSuccessful();

        $this->assertDatabaseHas('goals', [
            'id' => $goal->id,
            'progress' => 6000,
            'checked' => true
        ]);
    }
}
