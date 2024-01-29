<?php

namespace App\Http\Resources;

use App\Models\Member;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            "code"=> $this->code,
            "title" => $this->title,
            "author" => $this->author,
            'category' => new CategoryResource($this->category),
            'genres' => GenreResource::collection($this->genres),
            "cover" => url('/').'/storage/images/cover/'.$this->cover,
            "description" => $this->description,
            "no_of_book" => $this->no_of_book,
            "remain" => $this->remain,
            "credit_point" => $this->credit_point,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            'users' => $this->users->map(function($user){
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'pivot' => [
                        'order_id' => $user->pivot->order_id,
                        'status' => $user->pivot->status,
                    ]
                ];
            }),
        ];
    }
}
