<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\SellerProfile;


class HomeController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $pendingSellersCount = 0;
        $sellerStatus = null;

        if ($user->hasRole('Admin')) {
            $pendingSellersCount = SellerProfile::where('status', 'pending')->count();
        }

        if ($user->hasRole('Seller')) {
            $profile = $user->sellerProfile;
            $sellerStatus = $profile ? $profile->status : null;
        }
        return view('home.home', compact('pendingSellersCount', 'sellerStatus'));
    }
}
