<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

        // La tabla asociada al modelo en la base de datos.
        protected $table = 'cargos';

        protected $fillable = [
            'nombre',
        ];

        public function departamentoCargo(){
            return $this->hasMany(DepartamentoCargo::class, 'cargo_id');
        }
}
