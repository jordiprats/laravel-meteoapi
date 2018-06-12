<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Previsio;

class PrevisioResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    switch ($this->tipus)
    {
      case Previsio::PREVISIO_PLATJES:
        return [
          'data_previsio' => $this->data_previsio,
        ];
      case Previsio::PREVISIO_MUNICIPAL:
        return [
          'data_previsio' => $this->data_previsio,
          'temperatura_max' => $this->temperatura_max,
          'temperatura_min' => $this->temperatura_min,
          'probabilitat_precipitacio' => $this->probabilitat_precipitacio,
          'estat_cel' => $this->estat_cel,
        ];
    }

  }
}
