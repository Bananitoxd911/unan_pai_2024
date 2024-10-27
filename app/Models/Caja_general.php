<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja_general extends Model
{
    use HasFactory;

    // La tabla asociada al modelo en la base de datos.
    protected $table = 'caja_generals';

    // Los atributos que son asignables en masa.
    protected $fillable = [
        'empresa_id',
        'monto'
    ];

    // Define la relación "pertenece a" con el modelo Empresa.
    // Una caja general pertenece a una sola empresa.
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}
