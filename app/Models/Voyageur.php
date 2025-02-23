<?php

namespace App\Models;

use App\Models\EGoPass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voyageur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'type_vol',
        'numero_eGoPASS',
        'post_nom',
        'nationalite',
        'numero_passport',
        'compagnie_aerienne',
        'numero_vol',
        'provenance',
        'destination',
        'adresse_residence'
    ];

    public function eGoPasses() {
        return $this->hasMany(EGoPass::class);
    }

    public function abonne()
    {
        return $this->belongsTo(Abonne::class);
    }
}
