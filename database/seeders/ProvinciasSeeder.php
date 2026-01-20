<?php

namespace Database\Seeders;

use App\Models\Provincia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinciasSeeder extends Seeder
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
                Provincia::firstOrCreate([
                    'gcd_provincia' => $data[5],
                    'nombre' => $data[5] == 'ES701' ? 'Las Palmas' : 'Santa Cruz de Tenerife',
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
