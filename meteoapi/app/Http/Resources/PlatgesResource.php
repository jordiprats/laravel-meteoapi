<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlatgesResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      PlatgesResource::withoutWrapping();
      return [
        'platges' => PlatjaResource::collection($this->collection),
      ];
    }
}
