@extends('home.layouts.app')


@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between">
        <h2 class="text-xl font-bold mb-4">{{ $role->name }}</h2>
        <button type="button" class="mb-4 px-2 py-1 bg-green-600 text-white rounded"
            data-bs-toggle="modal" data-bs-target="#addUserModal">
            Add {{ $role->name }}
        </button>
    </div>
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">ID</th>
                <th class="border p-2">Name</th>
                <th class="border p-2">Username</th>
                <th class="border p-2">Email</th>
                <!-- <th class="border p-2">Store</th>
                <th class="border p-2">Submitted</th> -->
                <th class="border p-2">Status</th>
                @if($role->name == 'Seller')
                <th class="border p-2">Seller Status</th>
                @endif
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $p)
            <tr>
                <td class="border p-2">{{ $p->id }}</td>
                <td class="border p-2">{{ $p->name }}</td>
                <td class="border p-2">{{ $p->username }}</td>
                <td class="border p-2">{{ $p->email }}</td>
                <!-- <td class="border p-2">{{ $p->store_name }}</td>
                <td class="border p-2">{{ $p->created_at->toDateString() }}</td> -->
                <td class="border p-2">
                    <form action="{{ route('users.changeStatus', $p) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="px-2 py-1 border rounded">
                            <option value="active" {{ $p->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $p->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="banned" {{ $p->status === 'banned' ? 'selected' : '' }}>Banned</option>
                        </select>
                    </form>
                </td>
                @if($role->name == 'Seller')
                <td class="border p-2">
                    <form action="{{ route('users.sellers.changeStatus', $p->sellerProfile) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <select name="seller_status" onchange="this.form.submit()" class="px-2 py-1 border rounded">
                            <option value="pending" {{ $p->sellerProfile->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $p->sellerProfile->status === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $p->sellerProfile->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </form>
                </td>
                @endif
                <td class="border p-2">
                    <!-- <button type="button" class="px-2 py-1 bg-blue-600 text-white rounded"
                        data-bs-toggle="modal" data-bs-target="#editUserModal{{ $p->id }}">
                        Edit
                    </button> -->
                    <button class="edit-user-btn px-2 py-1 bg-blue-600 text-white rounded"
                        data-id="{{ $p->id }}" data-bs-toggle="modal" data-bs-target="#editUserModal">
                        Edit
                    </button>
                    <form action="{{ route('users.remove', $p) }}" method="POST" style="display:inline">@csrf
                        <button class="px-2 py-1 bg-red-600 text-white rounded">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @if (count($users) == 0)
            <tr>
                <td colspan="7" class="border p-2 text-center">No Record.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@include('home.admin.users.partials.addUserModal', ['role' => $role])
@include('home.admin.users.partials.editUserModal')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-user-btn');
    const modalBody = document.getElementById('editUserBody');
    const form = document.getElementById('editUserForm');

    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.dataset.id;

            fetch(`/users/${userId}/edit`)
                .then(res => res.text())
                .then(html => {
                    modalBody.innerHTML = html;
                    form.action = `/users/${userId}/update`; 
                });
        });
    });
});
</script>
@endsection
