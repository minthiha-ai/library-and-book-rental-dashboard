<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'user_code', 'user_qr', 'member_code', 'member_qr'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
