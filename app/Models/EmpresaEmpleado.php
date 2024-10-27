<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaEmpleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'empleado_id',

    ];
}
