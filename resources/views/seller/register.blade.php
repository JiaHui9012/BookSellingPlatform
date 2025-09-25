@extends('layouts.app')


@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Seller Registration</h2>
    <form action="{{ route('seller.register.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block">Name</label>
            <input name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block">Email</label>
            <input name="email" type="email" value="{{ old('email') }}" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block">Password</label>
                <input name="password" type="password" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block">Confirm Password</label>
                <input name="password_confirmation" type="password" class="w-full border p-2 rounded" required>
            </div>
        </div>
        <div class="mb-4">
            <label class="block">Store Name</label>
            <input name="store_name" value="{{ old('store_name') }}" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block">Phone</label>
            <input name="phone" value="{{ old('phone') }}" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block">Bio</label>
            <textarea name="bio" class="w-full border p-2 rounded">{{ old('bio') }}</textarea>
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Register</button>
    </form>
</div>
@endsection