<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'link' => $this->link,
            'creation_date' => $this->created_at->format('d.m.Y H:i:s')
        ];

        if ($this->relationLoaded('votes')) {
            $data['upvotes'] = $this->votes->count();
        }

        if ($this->relationLoaded('comments')) {
            $data['comments'] = $this->comments->count();
        }

        if ($this->relationLoaded('user')) {
            $data['author_name'] = $this->user->name;
        }

        return $data;
    }
}
