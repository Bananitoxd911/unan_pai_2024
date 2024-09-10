<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    use HasFactory;

    protected $table = 'nominas';

    protected $fillable = [
        'id_empresa',
        'fecha',
        'total',
    ];

    // Relación inversa con Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    // Relación con DetalleNomina
    public function detalleNomina()
    {
        return $this->hasMany(DetalleNomina::class, 'id_nomina');
    }
}
