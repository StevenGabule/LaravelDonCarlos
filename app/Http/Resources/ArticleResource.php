<?php

namespace App\Http\Resources;

use App\ArticleCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => ArticleCategory::find($this->category_id)->name,
            'status' => $this->status,
            'date' => $this->created_at->diffForHumans()
        ];
    }
}
