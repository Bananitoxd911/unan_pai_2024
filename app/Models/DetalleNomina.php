<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleNomina extends Model
{
    use HasFactory;

    protected $table = 'detalle_nomina';

    protected $fillable = [
        'id_nomina',
        'id_empleado',
        'salario_bruto',
        'cantidad_hrs_extra',
        'inss_patronal',
        'vacaciones',
        'treceavo_mes',
    ];

    // Relación inversa con Nomina
    public function nomina()
    {
        return $this->belongsTo(Nomina::class, 'id_nomina');
    }

    // Relación inversa con Empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }
}
