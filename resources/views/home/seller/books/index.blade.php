@extends('home.layouts.app')


@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">My Books</h2>

    @if(session('success'))
        <p class="text-green-600 mb-4">{{ session('success') }}</p>
    @endif

    <!-- Add new book -->
    <button class="px-4 py-2 bg-blue-600 text-white rounded mb-4" data-bs-toggle="modal" data-bs-target="#addBookModal">Add Book</button>

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Title</th>
                <th class="border p-2">Price</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr>
                    <td class="border p-2">{{ $book->title }}</td>
                    <td class="border p-2">${{ $book->price }}</td>
                    <td class="border p-2 space-x-2">
                        <a href="{{ route('books.edit', $book) }}" class="px-2 py-1 bg-yellow-500 text-white rounded">Edit</a>

                        <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('books.addBookModal') {{-- Create modal for adding book --}}
@endsection