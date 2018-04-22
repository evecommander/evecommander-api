<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
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
            'type' => 'characters',
            'id' => $this->id,
            'attributes' => [
                'eve_id' => $this->eve_id,
                'name' => $this->name
            ]
        ];
    }
}
