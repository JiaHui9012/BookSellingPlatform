@extends('layouts.app')


@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Pending Sellers</h2>
    <table class="w-full table-auto">
        <thead>
            <tr>
                <th class="border p-2">ID</th>
                <th class="border p-2">User</th>
                <th class="border p-2">Store</th>
                <th class="border p-2">Submitted</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pending as $p)
            <tr>
                <td class="border p-2">{{ $p->id }}</td>
                <td class="border p-2">{{ $p->user->email }}</td>
                <td class="border p-2">{{ $p->store_name }}</td>
                <td class="border p-2">{{ $p->created_at->toDateString() }}</td>
                <td class="border p-2">
                    <form action="{{ route('admin.sellers.approve', $p) }}" method="POST" style="display:inline">@csrf
                        <button class="px-2 py-1 bg-blue-600 text-white rounded">Approve</button>
                    </form>
                    <form action="{{ route('admin.sellers.reject', $p) }}" method="POST" style="display:inline">@csrf
                        <button class="px-2 py-1 bg-red-600 text-white rounded">Reject</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $pending->links() }}</div>
</div>
@endsection