<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SellerProfile;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class UserListController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:Admin');
    }

    public function index($role)
    {
        $role = Role::all()->firstWhere(function ($r) use ($role) {
            return Str::slug($r->name) === $role;
        });

        if (!$role) {
            abort(404);
        }

        $users = User::whereHas('roles', function ($q) use ($role) {
            // $q->where('name', ucfirst($role));
            $q->where('id', $role->id);
        })->get();

        return view('home.admin.users.index', compact('users', 'role'));
    }

    // public function edit(User $user)
    // {
    //     return view('admin.users.edit', compact('user'));
    // }

    public function store(Request $request)
    {
        $roleName = $request->role;

        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ];

        if ($roleName === 'Seller') {
            $rules['store_name'] = 'required|string|max:255';
            $rules['phone'] = 'nullable|string|max:50';
            $rules['bio'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        $user = DB::transaction(function () use ($validated, $roleName) {
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $role = Role::firstOrCreate(['name' => $roleName]);

            // Assign role to user
            $user->assignRole($role);

            // Assign permissions if Admin
            if ($roleName === 'Admin') {
                $permissions = $role->permissions()->pluck('name')->toArray();
                $user->givePermissionTo($permissions);
            }

            if ($roleName === 'Seller') {
                SellerProfile::create([
                    'user_id' => $user->id,
                    'store_name' => $validated['store_name'],
                    'phone' => $validated['phone'] ?? null,
                    'bio' => $validated['bio'] ?? null,
                    'status' => 'pending',
                ]);
            }

            return $user;
        });

        return redirect()->back()->with('success', 'User added successfully.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email', 'username']));

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function changeStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,banned',
        ]);

        $user->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'User status updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted.');
    }
}
