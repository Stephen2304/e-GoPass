<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaiementResource extends JsonResource
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
            'user_id' => $this->user_id,
            'montant' => $this->montant,
            'mode_paiement' => $this->mode_paiement,
            'reference' => $this->reference,
            'statut' => $this->statut,
            'e_go_passes_id' => $this->e_go_passes_id,
            
            // Ajoutez d'autres attributs si nécessaire
        ];
    }
} 