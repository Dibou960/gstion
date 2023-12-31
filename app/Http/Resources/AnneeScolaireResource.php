<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnneeScolaireResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'libelle' => $this->Libelle,
        ];
    }
}
