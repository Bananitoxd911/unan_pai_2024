<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Empleado;
use App\Models\DepartamentoCargo;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Lista de nombres y apellidos para generar datos de ejemplo
        $nombres = ['Juan', 'María', 'Carlos', 'Ana', 'Luis', 'Carmen', 'José', 'Laura', 'Miguel', 'Sofía'];
        $apellidos = ['Pérez', 'García', 'Rodríguez', 'González', 'López', 'Martínez', 'Sánchez', 'Ramírez', 'Torres', 'Hernández'];

        // Generar 50 empleados de ejemplo
        foreach (range(1, 50) as $index) {
            Empleado::create([
                'primer_nombre' => $nombres[array_rand($nombres)],
                'segundo_nombre' => rand(0, 1) ? $nombres[array_rand($nombres)] : null,
                'primer_apellido' => $apellidos[array_rand($apellidos)],
                'segundo_apellido' => $apellidos[array_rand($apellidos)],
                'numero_inss' => str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'antiguedad' => rand(1, 30), // Años de antigüedad entre 1 y 30
                'salario_bruto' => rand(300, 2000) * 10, // Salario entre 3000.00 y 20000.00
                'activo' => rand(0, 1), // Activo o inactivo
                'departamentocargo_id' => DepartamentoCargo::inRandomOrder()->first()->id, // Relación con `departamentocargo`
            ]);
        }
    }
}
