<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'gig_id', 'user_id', 'message', 'status'
    ];

    public function gig()
    {
        return $this->belongsTo(Gig::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
