<?php

namespace App\Models;

use App\Models\User;
use App\Models\Transaction;
use App\Models\EGoPass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant',
        'user_id',
        'mode_paiement',
        'reference',
        'statut',
        'e_go_passes_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function eGoPass()
    {
        return $this->belongsTo(EGoPass::class, 'e_go_passes_id');
    }

    public static function generateReference() {
        return 'REF-' . strtoupper(uniqid());
    }
}
