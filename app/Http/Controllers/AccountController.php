<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AccountController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('home.account', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ];

        if ($user->hasRole('Seller')) {
            $rules['store_name'] = 'required|string|max:255';
            $rules['phone'] = 'nullable|string|max:50';
            $rules['bio'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        if ($user->hasRole('Seller')) {
            $user->sellerProfile()->update(
                [
                    'store_name' => $validated['store_name'],
                    'phone'      => $validated['phone'] ?? null,
                    'bio'        => $validated['bio'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Account updated successfully.');
    }
}
