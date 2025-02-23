<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EGoPassRequest extends FormRequest
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
            'numero' => 'required|string|unique:e_go_passes,numero',
            'type' => 'required|string',
            'statut' => 'required|string',
            'date_generation' => 'required|date',
            'voyageur_id' => 'required|exists:voyageurs,id',
        ];
    }
} 