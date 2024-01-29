<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            "id" => $this->id,
            "title" => $this->title,
            "package_duration" => $this->package_duration,
            "book_per_rent" => $this->book_per_rent,
            "rent_duration" => $this->rent_duration,
            "price" => $this->price,
            "overdue_price_per_day" => $this->overdue_price_per_day,
            "overdue_price_per_week" => $this->overdue_price_per_week,
            "overdue_price_per_month" => $this->overdue_price_per_month,
            "image" => url('/').'/storage/images/package/'.$this->image,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
