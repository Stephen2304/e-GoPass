<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbonneRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'ville' => 'required|string|max:255',
        ];
    }
} 