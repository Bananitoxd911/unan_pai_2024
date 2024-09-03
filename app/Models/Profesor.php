<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Profesor extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'profesores';

    /**
     * Los atributos que se pueden asignar en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'contrasena',
    ];

    /**
     * Los atributos que deben ser ocultados para arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'contrasena',
    ];

    /**
     * Establece un mutador para la contraseña.
     *
     * @param string $value
     * @return void
     */
    public function setContrasenaAttribute($value)
    {
        $this->attributes['contrasena'] = bcrypt($value);
    }
}
