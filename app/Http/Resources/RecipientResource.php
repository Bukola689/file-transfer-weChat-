<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipientResource extends JsonResource
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
            'transfer_id' => UserResource::make($this->whenLoaded('transfer')) ?? null,
            'email' => $this->email,
            'has_downloaded' => $this->has_downloaded,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
