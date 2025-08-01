<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\admin\Wallet;
use App\Models\user\KYC;
use Illuminate\Http\Request;

class UserKycController extends Controller
{
    public function kyc()
    {
        $wallet = Wallet::first();
        return view('user.kyc', compact('wallet'));
    }

    public function index(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'idFront' => 'required',
            'idBack' => 'required',
            'selfie' => 'required',
            'paymentScreenshot' => 'required',
        ]);
        // front ID image save
        $idFrontImage = rand(1111111, 99999999) . '.' . $request->idFront->extension();
        $request->idFront->move(public_path('images/KYC'), $idFrontImage);
        // back ID image save
        $idBackImage = rand(1111111, 99999999) . '.' . $request->idBack->extension();
        $request->idBack->move(public_path('images/KYC'), $idBackImage);
        // selfie image save
        $selfieImage = rand(1111111, 99999999) . '.' . $request->selfie->extension();
        $request->selfie->move(public_path('images/KYC'), $selfieImage);
        // payment screenshot image save
        $paymentImage = rand(1111111, 99999999) . '.' . $request->paymentScreenshot->extension();
        $request->paymentScreenshot->move(public_path('images/KYC'), $paymentImage);

        $user_kyc = new KYC();
        $user_kyc->user_id = auth()->user()->id;
        $user_kyc->name = $request->name;
        $user_kyc->number = $request->number;
        $user_kyc->idFront = $idFrontImage;
        $user_kyc->idBack = $idBackImage;
        $user_kyc->selfie = $selfieImage;
        $user_kyc->paymentScreenshot = $paymentImage;
        $user_kyc->save();
        return redirect()->back()->with('success', 'KYC Uploaded Successfully');
    }
}
