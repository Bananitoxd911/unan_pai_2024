<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;

    // La tabla asociada al modelo en la base de datos.
    protected $table = 'bancos';

    // Los atributos que son asignables en masa.
    protected $fillable = [
        'id_empresa',
        'operacion',
        'balance',
    ];

    // Define la relación "pertenece a" con el modelo Empresa.
    // Un banco pertenece a una sola empresa.
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}
