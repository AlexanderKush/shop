<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function profile (User $user)
    {
        if (!Auth::user()) 
            return redirect()->route('home');
        if (Auth::user()->isAdmin() || $user->id == Auth::user()->id)
            return view('profile', compact('user'));

        return redirect()->route('home');
    }

    public function save ()
    {

        $input = request()->all();
        $name = $input['name'];
        $email = $input['email'];
        $userId = $input['userId'];
        $picture = $input['picture'] ?? null;
        $new_address = $input['new_address'];
        $password_new = $input['password_new'] ?? null;
        $user = User::find($userId);

        request()->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users,email,' . $user->id,
            'picture' => 'mimes:jpg,bmp,png,webp',
            'current_password' => 'current_password|required_with:password_new|nullable',
            'password_new' => 'confirmed|min:8|nullable'
        ]);

        Address::where('user_id', $user->id)->update([
            'main' => 0
        ]);

        Address::where('id', $input['address'])->update([
            'main' => 1
        ]);

        if ($new_address) {

            Address::where('user_id', $user->id)->update([
                'main' => 0
            ]);

            Address::create([
                'user_id' => $user->id,
                'address' => $new_address,
                'main' => 1
            ]);
        }

        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/users', $fileName);
            $user->picture = 'users/' . $fileName;
        }

        $user->name = $name;
        $user->email = $email;
        if ($password_new) {
            $user->password = Hash::make($password_new);
        }
        $user->save();

        session()->flash('profileSaved');

        return back();

    }

}
