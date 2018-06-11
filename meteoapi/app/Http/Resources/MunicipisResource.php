<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MunicipisResource extends ResourceCollection
{
  /**
   * Transform the resource collection into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    MunicipisResource::withoutWrapping();
    return [
      'municipis' => MunicipiResource::collection($this->collection),
    ];
  }
}
