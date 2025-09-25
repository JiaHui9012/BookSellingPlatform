<?php


namespace App\Http\Controllers;


use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class SellerRegistrationController extends Controller
{
    public function show()
    {
        return view('seller.register');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'store_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'bio' => 'nullable|string',
        ]);


        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);


            SellerProfile::create([
                'user_id' => $user->id,
                'store_name' => $validated['store_name'],
                'phone' => $validated['phone'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'status' => 'pending',
            ]);


            // Optionally send notification to admin here
        });


        return redirect()->route('login')->with('success', 'Registration submitted. Waiting for admin approval.');
    }
}
