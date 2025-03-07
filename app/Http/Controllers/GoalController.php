<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Auth;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Auth::check()){
            return redirect('/login');
        }
        $currentGoal = Auth::user()->goals()->where('checked',false)->first();
        $pastGoals = Auth::user()->goals()->where('checked',true)->get();
        return view('user.goals',['currentGoal'=>$currentGoal,'pastGoals'=>$pastGoals]);
    }
    public function store(Request $request)
    {
        if(!Auth::check()) return redirect('/login');
        $request->validate([
            'amount'=> 'numeric|min:200'
        ]);
        Goal::create(['user_id'=>Auth::id(),'amount'=>$request->amount]);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Goal $goal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goal $goal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Goal $goal)
    {
        $request->validate([
            'amount'=>'numeric|min:100'
        ]);
        $goal->update(['amount'=>$request->amount]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goal)
    {
        $goal->delete();
        return back();
    }
}
