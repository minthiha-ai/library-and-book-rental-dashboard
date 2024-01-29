<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'isBanned',
        'role',
        'fcm_token_key',
        'member_status',
        'user_code',
        'id_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function fcmTokenKey()
    {
        return $this->hasMany(FcmTokenKey::class, 'user_id', 'id');
    }

    public function rents()
    {
        return $this->hasMany(Rent::class, 'user_id');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'user_packages')->withPivot(['status','expire_date'])->withTimestamps();
    }

    public function rentBooks()
    {
        return $this->hasMany(RentBook::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function userCode()
    {
        return $this->hasOne(UserCode::class);
    }

    public function userPoint()
    {
        return $this->hasOne(UserPoint::class, 'user_id');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'user_books')
            ->withPivot(['order_id','status'])
            ->withTimestamps();
    }
    // public function books()
    // {
    //     return $this->belongsToMany(Book::class, 'order_items', 'book_id')
    //         ->withPivot('status')
    //         ->withTimestamps();
    // }
}
