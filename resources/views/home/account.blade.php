@extends('home.layouts.app')


@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <div class="flex justify-between">
        <h2 class="text-xl font-bold mb-4">My Account</h2>
    </div>
    <form action="{{ route('account.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block font-medium">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                class="w-full border p-2 rounded" required>
        </div>

        @if($user->hasRole('Seller'))
        <div>
            <label class="block font-medium">Store Name</label>
            <input type="text" name="store_name" value="{{ old('store_name', $user->sellerProfile->store_name) }}"
                class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block font-medium">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $user->sellerProfile->phone) }}"
                class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block font-medium">Bio</label>
            <textarea name="bio" class="w-full border p-2 rounded" rows="3">{{ old('bio', $user->sellerProfile->bio) }}</textarea>
        </div>
        @endif

        <div>
            <label class="block font-medium">New Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded">
            <small class="text-gray-500">Leave blank if you don’t want to change</small>
        </div>
        <div>
            <label class="block font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border p-2 rounded">
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                Update Account
            </button>
        </div>
    </form>
</div>
@endsection