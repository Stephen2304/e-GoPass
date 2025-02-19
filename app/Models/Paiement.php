<?php

namespace App\Models;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = ['utilisateur_id', 'montant', 'mode_paiement', 'reference', 'statut'];

    public function utilisateur() {
        return $this->belongsTo(User::class);
    }
    
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
