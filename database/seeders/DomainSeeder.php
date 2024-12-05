<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Domain;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $domains = [

            // SDI
            [
                'domain' => 'Prinsip Satu Data Indonesia',
                'aspek' => 'Standar Data Statistik',
                'indikator' => '10101. Penerapan Standar Data Statistik (SDS)',
            ],
            [
                'domain' => 'Prinsip Satu Data Indonesia',
                'aspek' => 'Metadata Statistik',
                'indikator' => '10201 Penerapan Metadata Statistik',
            ],
            [
                'domain' => 'Prinsip Satu Data Indonesia',
                'aspek' => 'Interoperabilitas Data',
                'indikator' => '10301 Penerapan Interoperabilitas Data',
            ],
            [
                'domain' => 'Prinsip Satu Data Indonesia',
                'aspek' => 'Kode Referensi dan/atau Data Induk',
                'indikator' => '10401 Penerapan Kode Referensi',
            ],

            // KUALITAS DATA
        ];

        foreach ($domains as $domain) {
            Domain::create($domain);
        }
    }
}
