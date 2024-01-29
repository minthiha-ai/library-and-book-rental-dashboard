<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'user' => new UserResource($this->user),
            'package' => new PackageResource($this->package),
            'payment' => new PaymentResource($this->payment),
            'payment_photo' => url('/').'/storage/images/payment/'.$this->payment_photo,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
