@extends('home.layouts.app')


@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Dashboard</h2>
    @role('Admin')
        @if($pendingSellersCount > 0)
            <p class="text-yellow-600">
                ⚠️ You have {{ $pendingSellersCount }} pending seller(s) waiting for approval.
            </p>
        @else
            <p class="text-green-600">✅ No pending sellers.</p>
        @endif
    @endrole

    @role('Seller')
        @if($sellerStatus === 'pending')
            <p class="text-yellow-600">
                ⚠️ Your account is waiting for approval. After approval, you will be able to upload books.
            </p>
        @elseif($sellerStatus === 'approved')
            <p class="text-green-600">
                ✅ Your account is approved. You can upload books now.
            </p>
        @elseif($sellerStatus === 'rejected')
            <p class="text-red-600">
                ❌ Your seller registration was rejected. Please contact support.
            </p>
        @else
            <p>ℹ️ You are not registered as a seller yet.</p>
        @endif
    @endrole
</div>
@endsection