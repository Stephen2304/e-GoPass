<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbonneResource extends JsonResource
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
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'ville' => $this->ville,
            // Ajoutez d'autres attributs si nécessaire
        ];
    }
} 