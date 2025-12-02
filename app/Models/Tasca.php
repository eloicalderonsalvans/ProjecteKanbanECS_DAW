<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasca extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_tasca';
    public $incrementing = true;
    protected  $fillable = ['titol','descripcio','prioritat','responsable','estat','posicio'];

    public function User(){

        return $this->belongsToMany(User::class);

    }
}
