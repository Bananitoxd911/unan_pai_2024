<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    // La tabla asociada al modelo en la base de datos.
    protected $table = 'departamentos';

    protected $fillable = [
        'nombre',
    ];
}
