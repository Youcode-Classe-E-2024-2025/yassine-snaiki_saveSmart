<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Auth;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(Request $request){
        $validated = $request->validate([
            'name'=>"required|string",
            'user_id'=>"required|string"
        ]);
        if(Auth::user()->id === $validated['user_id']){
            Category::create($validated);
        }
        return back();
    }
    public function delete(Request $request){
        $validated = $request->validate([
            'id'=>"required|string"
        ]);
        $category = Category::findOrFail($validated['id']);

        if(Auth::user()->id === $category->user_id){
            $category->delete();
        }
        return back();
    }
}
