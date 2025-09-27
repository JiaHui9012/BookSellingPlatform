<?php


namespace App\Http\Controllers;


use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('welcome');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            // 'email'      => 'required|email',
            'username'      => 'required|string',
            'password'      => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'username' => 'Incorrect username or password.',
        ])->withInput();
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'store_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'bio' => 'nullable|string',
        ]);


        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
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

            $role = Role::firstOrCreate(['name' => 'Seller']);

            // Assign role to user
            $user->assignRole($role);

            return $user;
        });

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registration submitted. Waiting for admin approval.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
