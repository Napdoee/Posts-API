<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'author' => $this->author,
            'title' => $this->title,
            'news_content' => $this->news_content,
            'created_at' => date_format($this->created_at, "Y/m/d H:s:i"),
            'writer' => $this->whenLoaded('writer'),
            'comments' => $this->whenLoaded('comments', function() {
                return collect($this->comments)->each(function($comment) {
                    $comment->comentator;
                    return $comment;
                });
            }),
            "comment_total" => $this->whenLoaded('comments', function() {
                return $this->comments->count();
            }),
        ];
    }
}
