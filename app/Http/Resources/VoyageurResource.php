<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VoyageurResource extends JsonResource
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
            'type_vol' => $this->type_vol,
            'numero_eGoPASS' => $this->numero_eGoPASS,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'post_nom' => $this->post_nom,
            'nationalite' => $this->nationalite,
            'numero_passport' => $this->numero_passport,
            'compagnie_aerienne' => $this->compagnie_aerienne,
            'numero_vol' => $this->numero_vol,
            'provenance' => $this->provenance,
            'destination' => $this->destination,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'adresse_residence' => $this->adresse_residence,
        ];
    }
} 