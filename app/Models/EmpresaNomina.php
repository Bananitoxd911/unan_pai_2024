<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaNomina extends Model
{
    use HasFactory;

    protected $table = 'empresa_nomina';

    protected $fillable = [
        'nomina_id',
        'empresa_id',
    ];

    public function nomina()
    {
        return $this->belongsTo(Nomina::class, 'nomina_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
