<?php

namespace Database\Seeders;

use App\Models\Isla;
use App\Models\Provincia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IslasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('storage\app\private\dataset-ISTAC_E30243A_000001_1.5_20260114182828.csv'), 'r');
        $firstline = true;

        while (($data = fgetcsv($csvFile, null, ',')) !== FALSE) {
            if (!$firstline) {
                if (Str::of($data[1])->startsWith("ES70") && $data[1] != "ES70") {
                    Isla::firstOrCreate([
                        'gcd_isla' => $data[1],
                        'nombre' => $data[0],
                        'gcd_provincia' => $this->asignarProvincia($data[1])
                    ]);
                }
            }
            $firstline = false;
        }

        fclose($csvFile);
    }

    public function asignarProvincia($codigoIsla){
        $csvFile = fopen(base_path('storage\app\private\municipios_desde2007_20170101.csv'), 'r');
        $firstline = true;

        while (($data = fgetcsv($csvFile, null, ',')) !== FALSE) {
            if (!$firstline) {
                if ($data[6] == $codigoIsla) {
                    return $data[5];
                }
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}