<?php

namespace App\Models;

use App\Models\EGoPass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voyageur extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'postnom', 'prenom', 'nationalite', 'passport_num', 'date_delivrance', 'tel', 'email', 'adresse'];

    public function eGoPasses() {
        return $this->hasMany(EGoPass::class);
    }

    
}
