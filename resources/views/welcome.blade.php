@extends('auth.app')


@section('content')
@if (!auth()->check())
<h1 class="mb-1 font-medium">Login</h1>
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-2 rounded mb-3 dark:text-[#FF4433]">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('login.store') }}" method="POST" class="mb-2">
    @csrf
    <div class="mb-4">
        <label class="block">Username</label>
        <input name="username" value="{{ old('username') }}" class="w-full border p-2 rounded" required>
    </div>
    <div class="mb-4 grid grid-cols-2 gap-4">
        <label class="block">Password</label>
        <input name="password" type="password" class="w-full border p-2 rounded" required>
    </div>
    <button class="w-full inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">
        Login
    </button>
</form>
<div class="text-center">
    <a href="{{ route('register') }}" target="" class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#f53003] dark:text-[#FF4433] ml-1">
        Create Account
    </a>
</div>
@endif
@endsection