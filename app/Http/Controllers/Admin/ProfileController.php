<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show edit form for admin profile.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('admin.profile', [
            'user' => $user,
        ]);
    }

    /**
     * Update admin profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if(!empty($data['password'])){
            $user->password = bcrypt($data['password']);
        }
        $user->save();

        return redirect()->route('admin.profile')->with('status', 'Profil diperbarui.');
    }
}
