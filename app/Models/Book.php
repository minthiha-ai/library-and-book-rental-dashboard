<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title','author','category_id','cover', 'no_of_book','remain','price','status','description','code','credit_point'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }

    public function rents()
    {
        return $this->hasMany(Rent::class, 'book_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_books')
            ->withPivot(['order_id','status'])
            ->withTimestamps();
    }
    // public function orders()
    // {
    //     return $this->hasManyThrough(Order::class, OrderItem::class);
    // }

    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class, 'order_items')->withPivot('status');
    // }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'order_items', 'book_id')
    //         ->withPivot('status')
    //         ->withTimestamps();
    // }
}
