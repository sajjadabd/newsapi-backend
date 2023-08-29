<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use Carbon\Carbon;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'source' => $this->source,
            'source_id' => $this->source_id,
            'author' => $this->author,
            'url' => $this->url,
            'urlToImage' => $this->urlToImage,
            'publishedAt' => $this->publishedAt,
            'content' => $this->content,
            'diffForHumans' => Carbon::parse($this->publishedAt)->diffForHumans(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
