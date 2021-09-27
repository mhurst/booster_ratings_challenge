<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FundraiserResource extends JsonResource
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
            'fundraiser_id' => $this->fundraiser_id,
            'fundraiser_name' => $this->fundraiser_name,
            'average_rating' => $this->average_rating,
        ];
    }
}
