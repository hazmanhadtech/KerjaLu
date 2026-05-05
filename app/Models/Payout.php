<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = [
        'user_id', 'recipient_id', 'amount', 'payable_type', 'payable_id', 'status', 'payment_method'
    ];

    public function payer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function payable()
    {
        return $this->morphTo();
    }
}
