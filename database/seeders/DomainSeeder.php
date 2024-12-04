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
            [
                'domain' => 'Prinsip Satu Data Indonesia',
                'aspek' => 'Standar Data Statistik',
                'indikator' => 'Indikator 1',
            ],
            [
                'domain' => 'Kualitas Data',
                'aspek' => 'Relevansi',
                'indikator' => 'Indikator 1',
            ],
        ];

        foreach ($domains as $domain) {
            Domain::create($domain);
        }
    }
}
