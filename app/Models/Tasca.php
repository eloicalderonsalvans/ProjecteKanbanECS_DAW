<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasca extends Model
{
    use HasFactory;

    protected  $fillable = ['titol','descripcio','prioritat','responsable'];

    public function User(){

        return $this->belongsToMany(User::class);

    }
}
