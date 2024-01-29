<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCodeResource extends JsonResource
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
            'user_code' => $this->user_code,
            'user_qr' => $this->user_qr,
            'member_code' => $this->member_code,
            'member_qr' => $this->member_qr,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
