<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\user\KYC;
use Illuminate\Http\Request;

class UserKycController extends Controller
{
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
        $idFrontImage = time() . '.' . $request->idFront->extension();
        $request->idFront->move(public_path('images/KYC'), $idFrontImage);
        // back ID image save
        $idBackImage = time() . '.' . $request->idBack->extension();
        $request->idBack->move(public_path('images/KYC'), $idBackImage);
        // selfie image save
        $selfieImage = time() . '.' . $request->selfie->extension();
        $request->selfie->move(public_path('images/KYC'), $selfieImage);
        // payment screenshot image save
        $paymentImage = time() . '.' . $request->paymentScreenshot->extension();
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
