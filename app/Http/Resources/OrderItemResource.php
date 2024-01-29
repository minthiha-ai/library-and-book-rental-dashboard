<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $createdAt = Carbon::parse($this->created_at)->setTimezone('Asia/Yangon');
        $updatedAt = Carbon::parse($this->updated_at)->setTimezone('Asia/Yangon');

        return [
            'id' => $this->id,
            // 'user_id' => $this->user_id,
            'book' => new BookResource($this->book),
            // 'status' => $this->status,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
