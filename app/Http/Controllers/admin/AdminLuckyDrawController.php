<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\LuckyDrawItems;
use App\Models\User;
use App\Models\user\LuckyParticipant;
use App\Models\user\UserBalance;
use App\Models\user\UserDeposit;
use App\Notifications\NewLotteryNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

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
        // Get all users
        $users = User::all();

        // Send notification to all
        FacadesNotification::send($users, new NewLotteryNotification($luckyItems->name));


        return redirect()->back()->with('success', '' . $request->name . ' added successfully');
    }

    public function all()
    {
        $luckyItems = LuckyDrawItems::get();
        return view('admin.luckyDraw.all', compact('luckyItems'));
    }

    public function requests()
    {
        $deposit = UserDeposit::get();
        return view('admin.luckyDraw.deposit', compact('deposit'));
    }

    public function approveReq($id)
    {
        $deposit = UserDeposit::find($id);
        if ($deposit->status == 'pending') {
            $user = UserBalance::where('user_id', $deposit->user_id)->first();
            if ($user) {
                $user->balance += $deposit->amount;
                $user->save();
                // approve status
                $deposit->status = 'approved';
                $deposit->save();
                return redirect()->back()->with('success', 'Balance Approved');
            } else {
                $userBalance = new UserBalance();
                $userBalance->user_id = $deposit->user_id;
                $userBalance->balance += $deposit->amount;
                $userBalance->save();
                // approve status
                $deposit->status = 'approved';
                $deposit->save();
                return redirect()->back()->with('success', 'Balance Approved');
            }
        }
    }

    public function participante()
    {
        $participante = LuckyParticipant::get();
        return view('admin.luckyDraw.participant', compact('participante'));
    }

    public function winner(Request $request)
    {
        $request->validate([
            'duration_minutes' => 'required|integer|min:1',
            'winner_draw_id' => 'required|string|max:255',
        ]);

        $start = Carbon::now();
        $end   = $start->copy()->addMinutes($request->duration_minutes);

        $data = [
            'duration_minutes' => $request->duration_minutes,
            'start_time' => $start,
            'end_time' => $end,
            'winner_draw_id' => $request->winner_draw_id,
            'is_active' => true,
        ];

        $draw = LuckyParticipant::create($data);


        $lucky_winner = LuckyParticipant::where('user_luckyDrawID', $request->winner)->first();
        $lucky_winner->status = "winner";
        $lucky_winner->save();
        return redirect()->back()->with('success', 'Great!' . $lucky_winner->user_email . ' selected as a Winner');
    }

    public function delItem($id)
    {
        $item = LuckyDrawItems::find($id);
        $item->delete();
        return redirect()->back()->with('success', 'Item Deleted');
    }

    public function delParticipant($id)
    {
        $participante = LuckyParticipant::find($id);
        $participante->delete();
        return redirect()->back()->with('success', 'Participante Deleted');
    }
}
