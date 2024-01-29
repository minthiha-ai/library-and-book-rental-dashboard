<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPoint extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','credit_point_id','payment_id', 'payment_photo'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function credit_point()
    {
        return $this->belongsTo(CreditPoint::class, 'credit_point_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
