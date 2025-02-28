<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Profile;
use Auth;
use Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function profile(Request $request,$id){
        if(!Auth::check())
        return redirect('/login');

        $credentials = $request->validate([
            'password' => 'required|digits:4',
        ]);
        $profile = Profile::findOrFail($id);

        if(Hash::check($credentials['password'],$profile->password)) {
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
        
        return view('user.profile', ['profile' => $profile,'categories' => Category::all()]);
    }

    public function closeProfile()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        session()->forget("profile_authenticated");
        return redirect('/user/profiles');
    }



    public function profiles(Request $request){
        if(Auth::check())
        return view('user.profiles');
        return redirect('/login');
    }
    public function createProfile(Request $request){
        if(!Auth::check())
        return redirect('/login');
        $credentials = $request->validate([
            'username' => 'required|string|min:4',
            'password' => 'required|digits:4',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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
