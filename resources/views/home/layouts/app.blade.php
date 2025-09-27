<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Book Selling Platform') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow h-screen fixed">
        <div class="p-4 border-b">
            <a href="/" class="text-xl font-bold">📚 {{ config('app.name', 'Book Selling Platform') }}</a>
        </div>
        <nav class="mt-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('home') }}" class="block px-4 py-2 hover:bg-gray-200">🏠 Dashboard</a>
                </li>
                @role('Admin')
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        👥 Users
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="">Sellers</a>
                        </li>
                    </ul>
                </li> -->
                <li>
                    <a href="" class="block px-4 py-2 hover:bg-gray-200">👥 Users</a>
                </li>
                <li>
                    <a href="{{ route('users.sellers.pending') }}" class="block px-4 py-2 hover:bg-gray-200">✅ Seller Approval</a>
                </li>
                <li>
                    <a href="" class="block px-4 py-2 hover:bg-gray-200">🏷️ Category</a>
                </li>
                @endrole
                @can('create book')
                <li>
                    <a href="" class="block px-4 py-2 hover:bg-gray-200">📚 Books</a>
                </li>
                @endcan
                <li>
                    <a href="" class="block px-4 py-2 hover:bg-gray-200">🧾 Orders</a>
                </li>
                <li>
                    <a href="" class="block px-4 py-2 hover:bg-gray-200">👤 {{ auth()->user()->name }}</a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="px-4">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 hover:bg-gray-200">🚪 Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 ml-64 p-6">
        @if(session('success'))
        <div class="bg-green-100 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>
</body>

</html>