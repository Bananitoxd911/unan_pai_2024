<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'logo',
        'nombre',

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
        $logos = implode(',', array_map(fn($i) => "logos/{$i}.svg", range(1, 19)));

        return [
            'logo' => 'required|string|in:' . $logos,
            'nombre' => 'required|string|max:255',
            
            'rubro' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
        ];
    }

    public function empleados()
    {
        return $this->belongsToMany(Empleado::class, 'empresa_empleado', 'empresa_id', 'empleado_id');
    }

}
