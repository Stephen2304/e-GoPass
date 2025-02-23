<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EGoPassResource extends JsonResource
{
    /**
     * Transforme la ressource en un tableau de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'type' => $this->type,
            'statut' => $this->statut,
            'date_generation' => $this->date_generation,
            'user_id' => $this->user_id,
            'voyageur_id' => $this->voyageur_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
} 