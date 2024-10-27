<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleNomina extends Model
{
    use HasFactory;

    protected $table = 'detalle_nomina';

    protected $fillable = [
        'empresaempleado_id',
        'cantidad_hrs_extras',
        'monto_hrs_extra',
        'antiguedad_porcentaje',
        'total_ingreso',
        'inss_laboral',
        'total_deducciones',
        'neto_recibir',
        'inss_patronal',
        'inatec',
        'vacaciones',
        'treceavomes',

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