<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planta extends Model
{
    protected $fillable = [
        'nome',
        'nome_cientifico',
        'descricao',
        'foto',
    ];
}
