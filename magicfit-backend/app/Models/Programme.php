<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'categorie', 'image'];

    public function exercices()
    {
        return $this->hasMany(Exercice::class);
        // return $this->belongsToMany(Exercice::class, 'exercice_programme');
    }
}
