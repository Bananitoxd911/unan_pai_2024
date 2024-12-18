<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'id_estudiante',
        'nombre',
        'logo',
        'rubro',
        'direccion',
        'telefono',
    ];

        /**
     * Obtiene las reglas de validación para la creación de una empresa.
     *
     * @return array
     */
    public static function rules()
    {
        $logos = implode(',', array_map(fn($i) => "logos/{$i}.svg", range(1, 14)));

        return [
            'nombre' => 'required|string|max:255',
            'logo' => 'required|string|in:' . $logos,
            'rubro' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
        ];
    }

    // Relación con el modelo Estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }
}
