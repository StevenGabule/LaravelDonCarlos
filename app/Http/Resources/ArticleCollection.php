<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{

    public function toArray($request) : array
    {
        return [
            'title' => $this->title
        ];
    }
}
