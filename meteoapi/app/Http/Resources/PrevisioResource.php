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
          'temperatura' => $this->temperatura,
          'humitat_relativa' => $this->humitat_relativa,
          'velocitat_vent' => $this->velocitat_vent,
          'direccio_vent' => $this->direccio_vent,
          'altura_ona' => $this->altura_ona,
          'direccio_ona' => $this->direccio_ona,
          'temperatura_aigua' => $this->temperatura_aigua,
          'uvi_maxim' => $this->uvi_maxim,
          'uvi_previst' => $this->uvi_previst,
          'estat_cel' => $this->estat_cel,
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
