@extends('auth.app')


@section('content')
<h1 class="mb-1 font-medium">Create Account</h1>
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-2 rounded mb-3 dark:text-[#FF4433]">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('register.store') }}" method="POST" class="mb-2">
    @csrf
    <div class="mb-4">
        <label class="block">Name</label>
        <input name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
    </div>
    <div class="mb-4">
        <label class="block">Userame</label>
        <input name="username" value="{{ old('username') }}" class="w-full border p-2 rounded" required>
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
    <button class="w-full inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">Register</button>
</form>
<div class="text-center">
    <a href="{{ route('login') }}" target="" class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#f53003] dark:text-[#FF4433] ml-1">
        Login
    </a>
</div>
@endsection