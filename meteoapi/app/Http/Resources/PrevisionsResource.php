<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PrevisionsResource extends ResourceCollection
{
  /**
   * Transform the resource collection into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    PrevisionsResource::withoutWrapping();
    return [
      'previsio' => PrevisioResource::collection($this->collection),
    ];
  }
}
