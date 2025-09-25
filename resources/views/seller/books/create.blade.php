@extends('layouts.app')


@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Upload Book</h2>
    <form action="{{ route('seller.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block">Title</label>
            <input name="title" value="{{ old('title') }}" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block">Description</label>
            <textarea name="description" class="w-full border p-2 rounded">{{ old('description') }}</textarea>
        </div>
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block">Price (MYR)</label>
                <input name="price" value="{{ old('price', '0.00') }}" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block">Stock</label>
                <input name="stock" type="number" value="{{ old('stock',1) }}" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block">Category</label>
                <select name="category_id" class="w-full border p-2 rounded">
                    <option value="">-- None --</option>
                    @foreach($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="mb-4">
            <label class="block">Cover Image</label>
            <input type="file" name="cover" accept="image/*" required>
        </div>
        <div class="mb-4">
            <label class="block">Book PDF (optional)</label>
            <input type="file" name="pdf" accept="application/pdf">
        </div>
        <button class="bg-green-600 text-white px-4 py-2 rounded">Upload Book</button>
    </form>
</div>
@endsection