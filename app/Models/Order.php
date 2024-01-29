<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name','phone','address',
        'sub_total','grand_total',
        'region_id','delivery_fee', 'delivery_fee_id',
        'start_date','overdue_date', 'return_date', 'status','state','credit_point'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function deliveryFee()
    {
        return $this->belongsTo(DeliveryFee::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // public function book()
    // {
    //     return $this->belongsTo(Book::class);
    // }

    // public function books()
    // {
    //     return $this->belongsToMany(Book::class, 'order_items')
    //         ->withPivot('status')
    //         ->withTimestamps();
    // }

    public static function createOrderItems($orderId, $books)
    {
        $orderItems = [];
        foreach ($books as $value) {
            $book = Book::find($value['book_id']);
            if ($book->remain == 0) {
                throw new Exception("There is no remaining book for " . $book->title . ".");
            }
            $orderItem = [
                'order_id' => $orderId,
                'book_id' => $book->id,
                'quantity' => 1,
                // 'status' => 'pending'
            ];
            // $book->remain -= 1;
            // $book->save();
            $orderItems[] = $orderItem;
        }
        return $orderItems;
    }

    public static function returnable($updated_at, $state)
    {
        $now = Carbon::now();
        $day = ReturnDay::latest()->first();

        if ($now->diffInDays($updated_at) >= (int)$day->day && $state == 'rented') {
            return true;
        }
        return false;
    }

}
