<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()                                         // Show Profile Page of the user with his/her persnal info

    {
        $user = User::find(Auth::id());

        return view('userProfile.UserProfile', compact('user'));
    }

    public function update(Request $request)                       // Update the Persnal info of the user
    {
        $request->validate([                                        // validate the input field from the form
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'location' => 'max:255',
            'phone' => 'numeric|digits:10',
            'aboutyou' => 'max:255',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
        ]);

        $user = User::find(Auth::id());                              // Get the current Loged-in user's id


        $user->update([                                               // Update into database
            'name' => $request->name,
            'email' => $request->email,
            'location' => $request->location,
            'phone' => $request->phone,
            'about' => $request->aboutyou,
        ]);
        return back()->with('success', 'Profile updated successfully.');
    }

    public function showprofilephotoform()                          // Show Upload Profile Photo page
    {

        return view('userProfile.UpdateProfilePhoto');
    }


    public function updateprofilephoto(Request $request)             // Upload the Profile Photo
    {


        $data = $request->validate([                                   // Validate the image type and size of the image
            'photo' => 'mimes:jpeg,png,jpg,gif|max:10240',
        ]);
        if ($request->hasFile('photo')) {
            $imagepath = $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('pfp', $imagepath, 'public');
            $imagepath = 'pfp/' . $imagepath;
        } else {
            $imagepath = null;
        }

        $user = User::find(Auth::id());                              // get the current loged-in user's ud
        $user->update([
            'pfp' => $imagepath
        ]);
        return redirect('/user/profile')->with('success', 'Photo uploaded!!');
    }
}
