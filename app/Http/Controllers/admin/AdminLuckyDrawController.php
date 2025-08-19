<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\LuckyDrawItems;
use Illuminate\Http\Request;

class AdminLuckyDrawController extends Controller
{
    public function add()
    {
        return view('admin.luckyDraw.add');
    }

    public function store(Request $request)
    {
        // validate
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'image' => 'required',
        ]);

        $luckyImage = rand(1111111, 99999999) . '.' . $request->image->extension();
        $request->image->move(public_path('images/luckyDraw'), $luckyImage);

        $luckyItems = new LuckyDrawItems();
        $luckyItems->name = $request->name;
        $luckyItems->amount = $request->amount;
        $luckyItems->image = $luckyImage;
        $luckyItems->save();
        return redirect()->back()->with('success', '' . $request->name . ' added successfully');
    }

    public function all()
    {
        $luckyItems = LuckyDrawItems::get();
        return view('admin.luckyDraw.all', compact('luckyItems'));
    }
}
