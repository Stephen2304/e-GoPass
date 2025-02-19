<?php

namespace App\Models;

use App\Models\Voyageur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EGoPass extends Model
{
    use HasFactory;
    
    protected $fillable = ['voyageur_id', 'type', 'statut'];

    public function voyageur() {
        return $this->belongsTo(Voyageur::class);
    }
}
