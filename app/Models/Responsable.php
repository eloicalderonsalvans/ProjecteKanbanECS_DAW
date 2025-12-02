<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    // Nom de la taula, ja que no segueix la convenció de pluralització (responsables)
    protected $table = 'responsable'; 

    // Clau primària no estàndard (per defecte Laravel espera 'id')
    protected $primaryKey = 'id_resposable'; 

    // Camps que es poden assignar massivament
    protected $fillable = ['nom', 'cognom', 'edat'];

    /**
     * Defineix un accessor per obtenir el nom complet.
     */
    public function getNomCompletAttribute()
    {
        return "{$this->nom} {$this->cognom}";
    }
}