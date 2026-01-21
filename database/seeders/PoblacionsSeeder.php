<?php

namespace Database\Seeders;

use App\Models\Municipio;
use App\Models\Poblacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoblacionsSeeder extends Seeder
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
                // Comprobar columna EDAD_CODE, SEXO_CODE y el codigo de municipio y que sea la POBLACION
                $edad = null;

                if ($data[7] === 'Y_GE100') {
                    $edad = 100;
                } elseif (preg_match('/^Y(\d+)$/', $data[7], $match)) {
                    $edad = $match[1];
                }

                if (
                    $edad !== null
                    && Municipio::where('codigo', $data[1])->exists()
                    && ($data[5] == 'F' || $data[5] == 'M')
                    && $data[13] == 'POBLACION'
                ) {
                    Poblacion::firstOrCreate([
                        'periodo' => $data[2],
                        'sexo' => $data[5],
                        'edad' => $edad,
                        'cantidad' => $data[14],
                        'codigo_municipio' => $data[1]
                    ]);
                }
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
