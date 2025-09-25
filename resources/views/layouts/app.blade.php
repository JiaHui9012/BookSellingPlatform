<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow p-4">
        <div class="container mx-auto">
            <a href="/" class="font-bold">Book Platform</a>
        </div>
    </nav>
    <div class="container mx-auto mt-6">
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
    </div>
</body>

</html>