<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlatjaResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'nom' => $this->nom,
      'slug' => $this->slug,
      'latitude' => $this->latitude,
      'longitude' => $this->longitude,
      'municipi' => $this->municipi->nom,
      'municipi_slug' => $this->municipi->slug,
    ];
  }
}
