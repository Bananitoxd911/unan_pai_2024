<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    use HasFactory;

    protected $table = 'nomina';

    protected $fillable = [
        'fecha',
        'descripcion',
        'periodo',
        'total',
        'activo',
    ];

    public function detalles()
    {
        return $this->hasManyThrough(
            DetalleNomina::class, // Modelo final
            NominaDetalle::class,  // Modelo intermedio
            'nomina_id',           // Clave foránea en NominaDetalle que referencia a Nomina
            'id',                  // Clave foránea en DetalleNomina que se usa en NominaDetalle
            'id',                  // Clave local en Nomina
            'detalle_id'          // Clave local en NominaDetalle que referencia a DetalleNomina
        );
    }
    

}