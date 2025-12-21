<?php

namespace App\Models\user;

use Illuminate\Database\Eloquent\Model;

class LuckyParticipant extends Model
{
    protected $fillable = [
        'duration_minutes',
        'start_time',
        'end_time',
        'winner_name',
        'is_active',
        'status'
    ];

    protected $dates = ['start_time', 'end_time'];

    public function isRunning()
    {
        return $this->is_active && $this->start_time && now()->lt($this->end_time);
    }

    public function remainingSeconds()
    {
        if (!$this->start_time || !$this->end_time) return 0;
        $diff = $this->end_time->diffInSeconds(now(), false);
        return max(0, $diff);
    }
}
