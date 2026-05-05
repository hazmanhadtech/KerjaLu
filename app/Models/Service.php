<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title', 'description', 'price', 'address', 'latitude', 'longitude', 'is_active'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }
}
