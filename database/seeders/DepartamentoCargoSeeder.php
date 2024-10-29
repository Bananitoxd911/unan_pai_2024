<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departamento;
use App\Models\Cargo;
use App\Models\DepartamentoCargo;

class DepartamentoCargoSeeder extends Seeder
{
    public function run()
    {
        // Lista de departamentos
        $departamentos = [
            'Recursos Humanos',
            'Finanzas',
            'Desarrollo',
            'Ventas',
            'Marketing',
            'Producción',
            'Logística',
            'Calidad',
            'Compras',
            'Atención al Cliente'
        ];

        // Lista de cargos
        $cargos = [
            'Gerente',
            'Asistente',
            'Analista',
            'Supervisor',
            'Operador',
            'Desarrollador',
            'Ejecutivo de Ventas',
            'Especialista en Marketing',
            'Coordinador de Calidad',
            'Encargado de Compras'
        ];

        // Crear registros en la tabla `departamentos`
        foreach ($departamentos as $nombre) {
            Departamento::create(['nombre' => $nombre]);
        }

        // Crear registros en la tabla `cargos`
        foreach ($cargos as $nombre) {
            Cargo::create(['nombre' => $nombre]);
        }

        // Crear relaciones en la tabla `departamentocargo`
        $departamentos = Departamento::all();
        $cargos = Cargo::all();

        // Crear 25 relaciones aleatorias entre departamentos y cargos
        foreach (range(1, 25) as $index) {
            DepartamentoCargo::create([
                'departamento_id' => $departamentos->random()->id,
                'cargo_id' => $cargos->random()->id,
            ]);
        }
    }
}
