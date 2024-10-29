<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaEmpleado extends Model
{
    use HasFactory;
    protected $table = 'empresa_empleado'; // Cambia esto si el nombre es diferente
    protected $fillable = [
        'empresa_id',
        'empleado_id',

    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

/******  0547ce8a-71d2-457e-b860-bde84038185b  *******/
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
