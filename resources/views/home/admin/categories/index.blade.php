@extends('home.layouts.app')


@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <div class="flex justify-between">
        <h2 class="text-xl font-bold mb-4">Category</h2>
        <button class="px-2 py-1 bg-green-600 text-white rounded mb-4" data-bs-toggle="modal" data-bs-target="#categoryModalAdd">Add Category</button>
    </div>
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Name</th>
                <th class="border p-2">Description</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $c)
            <tr>
                <td class="border p-2">{{ $c->name }}</td>
                <td class="border p-2">{{ $c->description }}</td>
                <td class="border p-2">
                    <button class="px-2 py-1 bg-blue-600 text-white rounded edit-category-btn"
                        data-id="{{ $c->id }}" data-bs-toggle="modal" data-bs-target="#categoryModalEdit">
                        Edit
                    </button>
                    <form action="{{ route('categories.destroy', $c) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @if (count($categories) == 0)
            <tr>
                <td colspan="7" class="border p-2 text-center">No Record.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

@include('home.admin.categories.partials.categoryModal', ['type' => 'Add'])
@include('home.admin.categories.partials.categoryModal', ['type' => 'Edit'])
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-category-btn');
    const modalBody = document.getElementById('categoryModalBodyEdit');
    const form = document.getElementById('categoryFormEdit');

    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const categoryId = button.dataset.id;

            fetch(`/categories/${categoryId}/edit`)
                .then(res => res.text())
                .then(html => {
                    modalBody.innerHTML = html;
                    form.action = `/categories/${categoryId}`; 
                });
        });
    });
});
</script>
@endsection