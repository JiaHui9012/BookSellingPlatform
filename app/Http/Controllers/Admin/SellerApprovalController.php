<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\SellerProfile;
use Illuminate\Http\Request;


class SellerApprovalController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:Admin');
    }


    public function index()
    {
        $pending = SellerProfile::where('status', 'pending')->with('user')->paginate(20);
        return view('admin.sellers.index', compact('pending'));
    }


    public function approve(SellerProfile $seller)
    {
        $seller->update(['status' => 'approved', 'approved_at' => now()]);
        $seller->user->assignRole('Seller');
        // notify seller
        return redirect()->back()->with('success', 'Seller approved');
    }


    public function reject(SellerProfile $seller)
    {
        $seller->update(['status' => 'rejected']);
        // notify seller
        return redirect()->back()->with('success', 'Seller rejected');
    }
}
