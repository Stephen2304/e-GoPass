<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoyageurRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type_vol' => 'required|string|max:255',
            'numero_eGoPASS' => 'required|integer',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'post_nom' => 'required|string|max:255',
            'nationalite' => 'required|string|max:255',
            'numero_passport' => 'required|integer',
            'compagnie_aerienne' => 'required|string|max:255',
            'numero_vol' => 'required|string|max:255',
            'provenance' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'adresse_residence' => 'required|string|max:255',
        ];
    }
} 