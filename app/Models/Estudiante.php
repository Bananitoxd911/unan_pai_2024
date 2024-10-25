<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Estudiante extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'estudiantes';

    /**
     * Los atributos que se pueden asignar en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'carnet',
        'pin',
        'nombres',
        'apellidos',
    ];

    /**
     * Los atributos que deben ser ocultados para arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'pin',
    ];

    // Relación con el modelo Empresa
    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'estudiante_id');
    }
}
