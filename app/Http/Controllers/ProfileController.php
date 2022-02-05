<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function profile ($id)
    {
        $user = User::findOrFail($id);
        return view('profile', compact('user'));
    }

    public function save ()
    {

        $input = request()->all();
        $name = $input['name'];
        $email = $input['email'];
        $userId = $input['userId'];
        $picture = $input['picture'] ?? null;
        $new_address = $input['new_address'];
        $user = User::find($userId);

        request()->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users,email,' . $user->id,
            'picture' => 'mimes:jpg,bmp,png,webp'
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
        $user->save();

        return back();

    }

}
