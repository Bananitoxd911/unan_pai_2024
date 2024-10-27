<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudianteEmpresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id',
        'empresa_id',
    ];
}
