<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja_general extends Model
{
    use HasFactory;

    protected $table = 'caja_generals';

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
