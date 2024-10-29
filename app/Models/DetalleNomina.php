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
        'ir',
        'total_deducciones',
        'neto_recibir',
        'inss_patronal',
        'inatec',
        'vacaciones',
        'treceavomes',

    ];


    // Relación inversa con Empleado
    public function empresaempleado()
    {
        return $this->belongsTo(EmpresaEmpleado::class, 'empresaempleado_id');
    }

    public function detalles()
    {
        return $this->hasMany(NominaDetalle::class, 'nomina_id');
    }

    public function nominaDetalle(){
        return $this->hasMany(NominaDetalle::class, 'detalle_id');
    }

}