<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EvaluationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'company' => $this->company,
          'comment' => $this->comment,
          'stars' => $this->stars,
          'created_at' => Carbon::make($this->created_at)->format('d/m/y H:i'),
        ];
    }
}
