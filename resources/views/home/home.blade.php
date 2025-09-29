@extends('home.layouts.app')


@section('content')
<div class="max-w-4xl mx-auto bg-white p-4 sm:p-6 rounded shadow">
    <h2 class="text-lg sm:text-xl font-bold mb-4">Dashboard</h2>
    @role('Admin')
        @if($pendingSellersCount > 0)
            <p class="text-yellow-600 text-sm sm:text-base">
                ⚠️ You have {{ $pendingSellersCount }} pending seller(s) waiting for approval.
            </p>
        @else
            <p class="text-green-600 text-sm sm:text-base">✅ No pending sellers.</p>
        @endif
    @endrole

    @role('Seller')
        @if($sellerStatus === 'pending')
            <p class="text-yellow-600 text-sm sm:text-base">
                ⚠️ Your account is waiting for approval. After approval, you will be able to upload books.
            </p>
        @elseif($sellerStatus === 'approved')
            <p class="text-green-600 text-sm sm:text-base">
                ✅ Your account is approved. You can upload books now.
            </p>
        @elseif($sellerStatus === 'rejected')
            <p class="text-red-600 text-sm sm:text-base">
                ❌ Your seller registration was rejected. Please contact support.
            </p>
        @else
            <p class="text-gray-700 text-sm sm:text-base">
                ℹ️ You are not registered as a seller yet.
            </p>
        @endif
    @endrole
</div>
@endsection