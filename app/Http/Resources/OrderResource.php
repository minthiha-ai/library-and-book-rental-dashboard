<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->user->name,
            'phone' => $this->user->phone,
            'address' => $this->address,
            'region_id' => $this->region_id,
            'delivery_fee_id' => $this->delivery_fee_id,
            'delivery_fee' => $this->delivery_fee,
            'start_date' => $this->start_date,
            'overdue_date' => $this->overdue_date,
            'return_date' => $this->return_date,
            'status' => $this->status,
            'state' => $this->state,
            'returnable' => Order::returnable($this->updated_at, $this->state),
            'credit_point' => $this->credit_point,
            'created_at' => $this->created_at->setTimezone('Asia/Yangon'),
            'updated_at' => $this->updated_at->setTimezone('Asia/Yangon'),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'phone' => $this->user->phone,
                'email' => $this->user->email,
                'role' => $this->user->role,
                'isBanned' => $this->user->isBanned,
                'created_at' => $this->user->created_at->setTimezone('Asia/Yangon'),
                'updated_at' => $this->user->updated_at->setTimezone('Asia/Yangon'),
                'fcm_token_key' => $this->user->fcm_token_key,
                'member_status' => $this->user->member_status,
            ],
            'region' => [
                'id' => $this->region->id,
                'name' => $this->region->name,
                'cod' => $this->region->cod,
                'created_at' => $this->region->created_at->setTimezone('Asia/Yangon'),
                'updated_at' => $this->region->updated_at->setTimezone('Asia/Yangon'),
                'delivery_fees' => $this->region->delivery_fees,
            ],
            'order_items' => OrderItemResource::collection($this->orderItems),
        ];
    }
}
