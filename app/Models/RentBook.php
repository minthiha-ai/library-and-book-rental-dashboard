<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentBook extends Model
{
    use HasFactory;

    protected $fillable = ['book_id','user_id','status','start_date','overdue_date','return_date','price','state'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
