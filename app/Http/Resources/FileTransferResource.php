<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileTransferResource extends JsonResource
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
            'user_id' => UserResource::make($this->whenLoaded('user')) ?? null,
            'sender_email' => $this->sender_email,
            'subject' => $this->subject,
            'message' => $this->message,
            'password' => $this->password,
            'expires_at' => $this->expires_at,
            'download_limit' => $this->download_limit,
            'downloads' => $this->downloads,
            'notify_on_download' => $this->notify_on_download,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
