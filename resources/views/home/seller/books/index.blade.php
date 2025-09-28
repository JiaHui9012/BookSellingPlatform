@extends('home.layouts.app')


@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <div class="flex justify-between">
        <h2 class="text-xl font-bold mb-4">{{ auth()->user()->hasRole('Seller')? 'My ':'' }}Books</h2>
        @role('Seller')
        <button class="px-2 py-1 bg-green-600 text-white rounded mb-4" data-bs-toggle="modal" data-bs-target="#bookModalAdd">Add Book</button>
        @endrole
    </div>
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Title</th>
                <th class="border p-2">Description</th>
                <th class="border p-2">Price (MYR)</th>
                <th class="border p-2">Stock</th>
                <th class="border p-2">Cover Image</th>
                @role('Seller')
                <th class="border p-2">Actions</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td class="border p-2">{{ $book->title }}</td>
                <td class="border p-2">{{ $book->description }}</td>
                <td class="border p-2">RM {{ $book->price }}</td>
                <td class="border p-2">{{ $book->stock }}</td>
                <td class="border p-2"><img class="h-52" src="{{ $book->getFirstMediaUrl('covers') }}" /></td>
                @role('Seller')
                <td class="border p-2">
                    <button class="px-2 py-1 bg-blue-600 text-white rounded mb-4 edit-book-btn"
                        data-id="{{ $book->id }}" data-bs-toggle="modal" data-bs-target="#bookModalEdit">
                        Edit
                    </button>
                    <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded">Delete</button>
                    </form>
                </td>
                @endrole
            </tr>
            @endforeach
            @if (count($books) == 0)
            <tr>
                <td colspan="7" class="border p-2 text-center">No Record.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

@include('home.seller.books.partials.bookModal', ['type' => 'Add'])
@include('home.seller.books.partials.bookModal', ['type' => 'Edit'])
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-book-btn');
    const modalBody = document.getElementById('bookModalBodyEdit');
    const form = document.getElementById('bookFormEdit');

    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const bookId = button.dataset.id;

            fetch(`/books/${bookId}/edit`)
                .then(res => res.text())
                .then(html => {
                    modalBody.innerHTML = html;
                    form.action = `/books/${bookId}`; 
                });
        });
    });
});
</script>
@endsection