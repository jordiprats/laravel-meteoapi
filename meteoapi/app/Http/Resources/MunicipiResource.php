<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MunicipiResource extends JsonResource
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
      'comarca' => $this->comarca->nom,
      'comarca_slug' => $this->comarca->slug,
      // 'numero_platges' => $this->getPlatgesCount,
    ];
  }
}
