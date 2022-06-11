<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'content' => $this->content,
            'creation_date' => $this->created_at->format('d.m.Y H:i:s')
        ];

        if ($this->relationLoaded('user')) {
            $data = array_merge(
                ['author_name' => $this->user->name],
                $data
            );
        }

        $data = array_merge(
            ['id' => $this->id],
            $data
        );

        return $data;
    }
}
