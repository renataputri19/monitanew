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
            [
                'domain' => 'Kualitas Data',
                'aspek' => 'Relevansi',
                'indikator' => '20101 Relevansi Data terhadap Pengguna',
            ],
            [
                'domain' => 'Kualitas Data',
                'aspek' => 'Relevansi',
                'indikator' => '20102 Proses Identifikasi Kebutuhan Data',
            ],
            [
                'domain' => 'Kualitas Data',
                'aspek' => 'Akurasi',
                'indikator' => '20201 Penilaian Akurasi Data',
            ],
            [
                'domain' => 'Kualitas Data',
                'aspek' => 'Aktualitas dan Ketepatan Waktu',
                'indikator' => '20301 Penjaminan Aktualitas Data',
            ],
            [
                'domain' => 'Kualitas Data',
                'aspek' => 'Aktualitas dan Ketepatan Waktu',
                'indikator' => '20302 Pemantauan Ketepatan Waktu Diseminasi',
            ],
            [
                'domain' => 'Kualitas Data',
                'aspek' => 'Aksesibilitas',
                'indikator' => '20401 Ketersediaan Data untuk Pengguna Data',
            ],
            [
                'domain' => 'Kualitas Data',
                'aspek' => 'Aksesibilitas',
                'indikator' => '20402 Akses Media Penyebarluasan Data',
            ],
            [
                'domain' => 'Kualitas Data',
                'aspek' => 'Aksesibilitas',
                'indikator' => '20403 Penyediaan Format Data',
            ],
            [
                'domain' => 'Kualitas Data',
                'aspek' => 'Keterbandingan dan Konsistensi',
                'indikator' => '20501 Keterbandingan Data',
            ],
            [
                'domain' => 'Kualitas Data',
                'aspek' => 'Keterbandingan dan Konsistensi',
                'indikator' => '20502 Konsistensi Statistik',
            ],
        ];

        foreach ($domains as $domain) {
            Domain::create($domain);
        }
    }
}
