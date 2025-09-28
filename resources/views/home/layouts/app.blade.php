<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Book Selling Platform') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
                <li x-data="{ open: false }" class="nav-item">
                    <button
                        @click="open = !open"
                        class="nav-link block px-4 py-2 hover:bg-gray-200 w-full text-left">
                        👥 Users
                    </button>

                    <ul
                        x-show="open"
                        x-transition
                        class="ml-4 mt-2 space-y-2">
                        @foreach($roles as $p)
                        <li>
                            <a href="{{ route('users.index', ['role' => Str::slug($p->name)]) }}" class="block px-4 py-2 hover:bg-gray-200">{{ $p->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li>
                    <a href="{{ route('users.sellers.pending') }}" class="block px-4 py-2 hover:bg-gray-200">✅ Seller Approval</a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}" class="block px-4 py-2 hover:bg-gray-200">🏷️ Category</a>
                </li>
                @endrole
                @if (auth()->user()->hasDirectPermission('view books'))
                <li>
                    <a href="{{ route('books.index') }}" class="block px-4 py-2 hover:bg-gray-200">📚 Books</a>
                </li>
                @endif
                @if (auth()->user()->hasDirectPermission('view orders'))
                <li>
                    <a href="" class="block px-4 py-2 hover:bg-gray-200">🧾 Orders</a>
                </li>
                @endif
            </ul>
            <ul class="space-y-2 mb-4 absolute bottom-0 w-full">
                <li>
                    <a href="{{ route('account.index') }}" class="block px-4 py-2 hover:bg-gray-200">👤 {{ auth()->user()->name }}</a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="px-4 hover:bg-gray-200">
                        @csrf
                        <button type="submit" class="w-full text-left py-2">🚪 Logout</button>
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