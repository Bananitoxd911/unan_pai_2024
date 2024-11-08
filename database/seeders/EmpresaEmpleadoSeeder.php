<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Empleado;
use Illuminate\Support\Facades\DB;


class EmpresaEmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $empresaId = 1;
        $empleadoIds = Empleado::whereBetween('id', [5, 54])->pluck('id');

        foreach ($empleadoIds as $empleadoId) {
            DB::table('empresa_empleado')->insert([
                'empresa_id' => $empresaId,
                'empleado_id' => $empleadoId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
