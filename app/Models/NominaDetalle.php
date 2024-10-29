<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NominaDetalle extends Model
{
    use HasFactory;

    protected $table = 'nomina_detalle';

    protected $fillable = [
        'nomina_id',
        'detalle_id',
    ];

    public function detalle()
    {
        return $this->belongsTo(DetalleNomina::class, 'detalle_id');
    }

    public function nomina()
    {
        return $this->belongsTo(Nomina::class, 'nomina_id');
    }
}
