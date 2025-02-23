<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaiementRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette demande.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Changez cela selon vos besoins d'autorisation
    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la demande.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:0',
            'mode_paiement' => 'required|string|max:255',
            'reference' => 'required|string|max:255',
            'statut' => 'required|string|max:50',
            'e_go_passes_id'=> 'required|exists:e_go_passes,id',
        ];
    }
} 