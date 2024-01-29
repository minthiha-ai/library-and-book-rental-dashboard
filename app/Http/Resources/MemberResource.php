<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone ?? '',
            'email' => $this->email ?? '',
            'fcm_token_key' => $this->fcm_token_key,
            'role' => $this->role,
            'member_status' => $this->member_status,
            'isBanned' => $this->isBanned,
            'created_at' => $this->created_at->setTimezone('Asia/Yangon'),
            'updated_at' => $this->updated_at->setTimezone('Asia/Yangon'),
            'user_code' => new UserCodeResource($this->userCode),
            'points' => $this->userPoint?->point,
            'packages' => $this->whenLoaded('packages', function () {
                return $this->packages->map(function ($package) {
                    return [
                        'id' => $package->id,
                        'title' => $package->title,
                        'package_duration' => $package->package_duration,
                        'book_per_rent' => $package->book_per_rent,
                        'rent_duration' => $package->rent_duration,
                        'overdue_price_per_day' => $package->overdue_price_per_day,
                        'overdue_price_per_week' => $package->overdue_price_per_week,
                        'overdue_price_per_month' => $package->overdue_price_per_month,
                        'image' => url('/').'/storage/images/package/'.$package->image,
                        'status' => $package->pivot->status,
                        // 'expire_date' => $package->pivot->updated_at->copy()->addDays($package->package_duration),
                        'expire_date' => Carbon::parse($package->pivot->expire_date ?? $package->pivot->updated_at->copy()->addDays($package->package_duration))->utc()->format('Y-m-d\TH:i:s.u\Z'),
                        'created_at' => $package->pivot->created_at,
                        'updated_at' => $package->pivot->updated_at,
                    ];
                });
            }),
            'books' => $this->books->map(function ($book) {
                return [
                    "id" => $book->id,
                    "code"=> $book->code,
                    "title" => $book->title,
                    'pivot' => [
                        'order_id' => $book->pivot->order_id,
                        'status' => $book->pivot->status,
                    ],
                ];
            }),
        ];
    }
}
