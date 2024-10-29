<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';

    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'numero_inss',
        'antiguedad',
        'salario_bruto',
        'activo',
        'departamentocargo_id',
    ];

    public function departamentocargo()
    {
        return $this->belongsTo(DepartamentoCargo::class, 'departamentocargo_id');
    }

        // Relación de muchos a muchos con Empresa
        public function empresas()
        {
            return $this->belongsToMany(Empresa::class, 'empresa_empleado', 'empleado_id', 'empresa_id');
        }

}
