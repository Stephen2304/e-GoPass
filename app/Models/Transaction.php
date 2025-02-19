<?php

namespace App\Models;

use App\Models\User;
use App\Models\Paiement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['utilisateur_id', 'paiement_id', 'type', 'statut'];

    public function utilisateur() {
        return $this->belongsTo(User::class);
    }

    public function paiement() {
        return $this->belongsTo(Paiement::class);
    }
}
