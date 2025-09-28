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
        return view('home.admin.seller_approval.index', compact('pending'));
    }


    public function approve(SellerProfile $seller)
    {
        $seller->update(['status' => 'approved', 'approved_at' => now()]);
        $role = $seller->user->roles()->first();
        $permissions = $role->permissions;
        $seller->user->givePermissionTo($permissions);
        // notify seller
        return redirect()->back()->with('success', 'Seller approved');
    }


    public function reject(SellerProfile $seller)
    {
        $seller->update(['status' => 'rejected']);
        // notify seller
        return redirect()->back()->with('success', 'Seller rejected');
    }

    public function changeStatus(Request $request, SellerProfile $seller)
    {
        $request->validate([
            'seller_status' => 'required|in:pending,approved,rejected',
        ]);

        $seller->update(['status' => $request->seller_status]);

        $role = $seller->user->roles()->first();
        $permissions = $role->permissions;
        if ($request->seller_status == 'approved') {
            $seller->user->givePermissionTo($permissions);
        } else {
            $seller->user->revokePermissionTo($permissions);
        }

        return redirect()->back()->with('success', 'Seller status updated.');
    }
}
