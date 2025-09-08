<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\user\UserKycController;
use App\Models\SellVipPGN;
use App\Models\User;
use App\Models\user\BuyVipClass;
use App\Models\user\ContactUs;
use App\Models\user\KYC;
use App\Models\user\Links;
use App\Models\user\PremiumPlan;
use Illuminate\Http\Request;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;

class AdminDashboradController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('admin.dashboard', compact('users'));
    }

    public function kyc()
    {
        $kyc = KYC::get();
        return view('admin.kyc.requests', compact('kyc'));
    }

    public function contactRequest()
    {
        $request = ContactUs::get();
        return view('admin.contact.request', compact('request'));
    }

    public function pendingPremium()
    {
        $premium = PremiumPlan::get();
        return view('admin.premium.pending', compact('premium'));
    }

    public function approveKYC($id)
    {
        $kyc = KYC::find($id);
        $kyc->status = 'approved';
        $kyc->save();
        return redirect()->back()->with('success', 'KYC approved successfully');
    }

    public function rejectKYC($id)
    {
        $kyc = KYC::find($id);
        $kyc->status = 'rejected';
        $kyc->save();
        return redirect()->back()->with('success', 'KYC rejected successfully');
    }

    public function approvePremium($id)
    {
        $premium = PremiumPlan::find($id);
        $premium->status = 'approved';
        $premium->save();
        return redirect()->back()->with('success', 'Premium Plan Approved');
    }

    public function rejectPremium($id)
    {
        $premium = PremiumPlan::find($id);
        $premium->status = 'rejected';
        $premium->save();
        return redirect()->back()->with('success', 'Premium Plan Rejected');
    }

    public function addToken($id)
    {
        $premium = PremiumPlan::find($id);
        return view('admin.premium.addToken', compact('premium'));
    }

    public function storeToken(Request $request, $id)
    {
        $user = User::find($request->user_id);
        $user->balance += $request->amount;
        $user->save();
        return redirect()->back()->with('success', 'Token added successfully');
    }

    public function allTasks()
    {
        $tasks = Links::get();
        return view('admin.task.all', compact('tasks'));
    }

    public function deleteTask($id)
    {
        $task = Links::find($id);
        $task->delete();
        return redirect()->back()->with('success', 'Task Deleted Successfully');
    }

    public function addTask()
    {
        return view('admin.task.add');
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'amount' => 'required',
        ]);

        $link = new Links();
        $link->title = $request->title;
        $link->amount = $request->amount;
        $link->link = $request->link;
        $link->save();
        return redirect()->back()->with('success', 'Task Added successfull');
    }

    public function vipMembership()
    {
        $vip = BuyVipClass::get();
        return view('admin.vip.membership', compact('vip'));
    }

    public function approveMembership($id)
    {
        $vip = BuyVipClass::find($id);
        $vip->status = 'approved';
        $vip->save();
        return redirect()->back()->with('success', 'Membership Activated');
    }

    public function rejectMembership($id)
    {
        $vip = BuyVipClass::find($id);
        $vip->status = 'rejected';
        $vip->save();
        return redirect()->back()->with('success', 'Membership Rejected');
    }

    public function vipSell()
    {
        $vip_sell = SellVipPGN::get();
        return view('admin.vip.vipSell', compact('vip_sell'));
    }

    public function vipSellApprove($id)
    {
        $vip_sell = SellVipPGN::find($id);
        if ($vip_sell->status == 'approved') {
            return redirect()->back()->with('error', 'Already Approved');
        }
        $vip_sell->status = 'approved';
        $vip_sell->save();

        $user = User::where('id', $vip_sell->user_id)->first();
        $user->balance -= $vip_sell->pgn_amount;
        $user->save();

        return redirect()->back()->with('success', 'Token approved successfully');
    }
}
