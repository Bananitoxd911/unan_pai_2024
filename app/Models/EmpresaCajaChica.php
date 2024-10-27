<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaCajaChica extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'caja_chica_id',
    ];
}
