<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FondoFijo extends Model
{
    use HasFactory;

    protected $table = 'fondo_fijos';

    protected $fillable = [
        'id_empresa',
        'descripcion',
        'tipo',
        'monto',
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}
