@extends('home.layouts.app')


@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <div class="flex justify-between">
        <h2 class="text-xl font-bold mb-4">My Books</h2>
        <button class="px-4 py-2 bg-blue-600 text-white rounded mb-4" data-bs-toggle="modal" data-bs-target="#bookModalAdd">Add Book</button>
    </div>
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Title</th>
                <th class="border p-2">Description</th>
                <th class="border p-2">Price</th>
                <th class="border p-2">Stock</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td class="border p-2">{{ $book->title }}</td>
                <td class="border p-2">${{ $book->description }}</td>
                <td class="border p-2">${{ $book->price }}</td>
                <td class="border p-2">${{ $book->stock }}</td>
                <td class="border p-2">${{ $book->status }}</td>
                <td class="border p-2 space-x-2">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded mb-4" data-bs-toggle="modal" data-bs-target="#bookModalEdit{{ $book->id }}">Edit</button>
                    <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded">Delete</button>
                    </form>
                </td>
            </tr>
            @include('home.seller.books.bookModal', ['type' => 'Edit', 'book' => $book])
            @endforeach
            @if (count($books) == 0)
            <tr>
                <td colspan="7" class="border p-2 text-center">No Record.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

@include('home.seller.books.bookModal', ['type' => 'Add'])
@endsection