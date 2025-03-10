<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Profile;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function profile(Request $request, $id)
    {
        if (!Auth::check())
            return redirect('/login');

        $credentials = $request->validate([
            'password' => 'required|digits:4',
        ]);
        $profile = Profile::findOrFail($id);

        if (Hash::check($credentials['password'], $profile->password)) {
            session(["profile_authenticated" => $id]);
            return redirect("user/profiles/$id");
        }
        return back()->withErrors([
            'password' => 'incorrect credentials',
        ]);
    }


    public function showProfile($id)
    {

        if (!Auth::check()) {
            return redirect('/login');
        }
        if (!session("profile_authenticated")) {
            return redirect('/user/profiles')->withErrors(['message' => 'Unauthorized access']);
        }
        $profile = Profile::findOrFail($id);

        $totalIncome = Auth::user()->profiles()->sum('income');
        $totalExpense = 0;
        $periodStart = Carbon::now()->startOfMinute();
        $periodEnd = Carbon::now()->endOfMinute();
        foreach (Auth::user()->profiles as $pr) {
            $expenses = $pr->transactions()
                ->whereBetween('created_at', [$periodStart, $periodEnd])
                ->sum('amount');
            $totalExpense += $expenses;
        }
        $transactions = collect(); // Initialize a collection

        foreach (Auth::user()->profiles as $profile) {
            // Get the transactions for this profile for the current minute
            $profileTransactions = $profile->transactions()->whereBetween('created_at', [$periodStart, $periodEnd])->get();

            // Merge the transactions into the main collection
            $transactions = $transactions->merge($profileTransactions);
        }
        $goal = Auth::user()->goals()->where('checked', false)->first();

        return view('user.profile', ['profile' => $profile, 'categories' => Auth::user()->categories()->get()->all(), 'totalIncome' => $totalIncome, 'totalExpense' => $totalExpense, 'goal' => $goal, 'periodStart' => $periodStart, 'periodEnd' => $periodEnd, 'transactions' => $transactions]);
    }

    public function closeProfile()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        session()->forget("profile_authenticated");
        return redirect('/user/profiles');
    }



    public function profiles(Request $request)
    {
        if (Auth::check())
            return view('user.profiles');
        return redirect('/login');
    }
    public function createProfile(Request $request)
    {
        if (!Auth::check())
            return redirect('/login');
        $credentials = $request->validate([
            'username' => 'required|string|min:4',
            'password' => 'required|digits:4',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'income' => 'numeric|min:0'
        ]);
        if ($request->hasFile('avatar')) {
            $imagePath = $request->file('avatar')->store('avatars', 'public');
            $credentials['avatar'] = "/storage/" . $imagePath;
        }

        $credentials['user_id'] = Auth::user()->id;
        $credentials['password'] = Hash::make($credentials['password']);
        Profile::create($credentials);
        return redirect('/user/profiles');
    }
    public function deleteProfile($id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $profile = Profile::findOrFail($id);

        if ($profile->user_id == Auth::id()) {
            $profile->delete();
            return redirect()->back()->with('success', 'Profile deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'You are not authorized to delete this profile.');
        }
    }

}
