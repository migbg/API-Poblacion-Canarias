<?php

namespace Database\Seeders;

use App\Models\Municipio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('storage\app\private\municipios_desde2007_20170101.csv'), 'r');
        $firstline = true;

        while (($data = fgetcsv($csvFile, null, ',')) !== FALSE) {
            if (!$firstline) {
                Municipio::firstOrCreate([
                    'codigo' => $data[0],
                    'nombre' => $data[2],
                    'gcd_isla' => $data[6]
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
