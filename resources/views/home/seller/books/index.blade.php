@extends('home.layouts.app')


@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mb-4 flex">
    <div>
        @if(auth()->user()->hasRole('Admin'))
        <form action="{{ route('books.sellerfilter') }}" method="POST" style="display:inline">
            @csrf
            <select name="seller" onchange="this.form.submit()" class="p-2 mr-3 border rounded">
                <option value="0">All Sellers</option>
                @foreach($sellers as $s)
                <option value="{{ $s->user->id }}" {{ !empty($sellerfilter) && $s->user->id == $sellerfilter ? 'selected' : '' }}>{{ $s->user->name }}</option>
                @endforeach
            </select>
        </form>
        @endif
    </div>
    <div class="flex-1">
        <form action="{{ route('books.search') }}" method="GET" class="flex">
            <input class="form-control" type="text" name="keyword" placeholder="Search books..." value="{{ $keyword ?? '' }}">
            @if(!empty($sellerfilter))
            <input type="hidden" name="seller" value="{{ $sellerfilter }}">
            @endif
            <button class="w-32 ml-3 p-2 border rounded hover:bg-gray-100" type="submit">Search</button>
        </form>
    </div>
</div>
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <div class="flex justify-between">
        <h2 class="text-xl font-bold mb-4">{{ auth()->user()->hasRole('Seller')? 'My ':'' }}Books</h2>
        @role('Seller')
        <button class="px-2 py-1 bg-green-600 text-white rounded mb-4" data-bs-toggle="modal" data-bs-target="#bookModalAdd">Add Book</button>
        @endrole
    </div>
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-200">
                @role('Admin')
                <th class="border p-2">Seller</th>
                @endrole
                <th class="border p-2">Title</th>
                <th class="border p-2">Description</th>
                <th class="border p-2">Category</th>
                <th class="border p-2">Price (MYR)</th>
                <th class="border p-2">Stock</th>
                <th class="border p-2">Cover Image</th>
                @role('Seller')
                <th class="border p-2">Actions</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach($books as $bk)
            <tr>
                @role('Admin')
                <td class="border p-2">{{ $bk->seller->name }} ({{ $bk->seller->username }})</td>
                @endrole
                <td class="border p-2">{{ $bk->title }}</td>
                <td class="border p-2">{{ $bk->description }}</td>
                <td class="border p-2">
                    @if(auth()->user()->hasRole('Admin'))
                    <form action="{{ route('categories.updateBookCategory', $bk) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <select name="category_id" onchange="this.form.submit()" class="px-2 py-1 border rounded">
                            <option value="">-- None --</option>
                            @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ $bk->category_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </form>
                    @else
                    {{ $bk->category ? $bk->category->name : '-' }}
                    @endif
                </td>
                <td class="border p-2">RM {{ $bk->price }}</td>
                <td class="border p-2">{{ $bk->stock }}</td>
                <td class="border p-2"><img class="h-52" src="{{ $bk->getFirstMediaUrl('covers') }}" /></td>
                @role('Seller')
                <td class="border p-2">
                    <button class="px-2 py-1 bg-blue-600 text-white rounded edit-book-btn"
                        data-id="{{ $bk->id }}" data-bs-toggle="modal" data-bs-target="#bookModalEdit">
                        Edit
                    </button>
                    <form action="{{ route('books.destroy', $bk) }}" method="POST" style="display:inline">
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
                <td colspan="9" class="border p-2 text-center">No Record.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

@include('home.seller.books.partials.bookModal', ['type' => 'Add'])
@include('home.seller.books.partials.bookModal', ['type' => 'Edit'])
<script>
    document.addEventListener('DOMContentLoaded', function() {
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