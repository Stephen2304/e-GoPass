<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EGoPass extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'numero', 'type', 'statut', 'date_generation',
        'user_id', 'voyageur_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voyageur()
    {
        return $this->belongsTo(Voyageur::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class, 'e_go_passes_id');
    }
}
