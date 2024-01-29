<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'fcm_token_key' => $this->fcmTokenKey ?? '',
            'role' => $this->role,
            'isBanned' => $this->isBanned,
            // 'user_code' => new UserCodeResource($this->user_code),
            'user_code' => $this->userCode ?? '',
            'created_at' => $this->created_at
        ];

    }
}
