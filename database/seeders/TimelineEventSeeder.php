<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimelineEvent;

class TimelineEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $events = [
            [
                'task' => 'Persiapan Pelaksanaan Penilaian EPSS',
                'start_date' => '2025-01-01',
                'end_date' => '2025-03-15',
                'category' => 'Preparation',
            ],
            [
                'task' => 'Penilaian Mandiri di OPD',
                'start_date' => '2025-04-01',
                'end_date' => '2025-05-15',
                'category' => 'Assessment',
            ],
            [
                'task' => 'Penilaian Dokumen - TPB',
                'start_date' => '2025-05-16',
                'end_date' => '2025-06-30',
                'category' => 'Document Review',
            ],
            [
                'task' => 'Penilaian Interview - TPK',
                'start_date' => '2025-07-01',
                'end_date' => '2025-07-31',
                'category' => 'Interview',
            ],
            [
                'task' => 'Harmonisasi Pleno Provinsi',
                'start_date' => '2025-08-01',
                'end_date' => '2025-08-31',
                'category' => 'Harmonization',
            ],
        ];

        foreach ($events as $event) {
            TimelineEvent::create($event);
        }
    }
}
