<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;

    protected $table = 'bancos';

    protected $fillable = [
        'id_empresa',
        'operacion',
        'balance',
    ];

    // relación con empresa.
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}
