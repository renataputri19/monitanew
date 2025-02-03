<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {


        $users = [
            ['name' => 'Tresna Yudhistira', 'email' => 'tresnayudhistira@gmail.com', 'password' => Hash::make('sektoralbatam'), 'admin' => 0],
            ['name' => 'Muhammad Jasrol', 'email' => 'muhammadjasrol37@gmail.com', 'password' => Hash::make('sektoralbatam'), 'admin' => 0],
            ['name' => 'Tengku Indra', 'email' => 'indra.darmawan04@gmail.com', 'password' => Hash::make('sektoralbatam'), 'admin' => 0],
            ['name' => 'Andri Nurahman', 'email' => 'andri.nurahman@gmail.com', 'password' => Hash::make('sektoralbatam'), 'admin' => 0],
            ['name' => 'Rini Afriyanti', 'email' => 'rini.afriyanti73@gmail.com', 'password' => Hash::make('sektoralbatam'), 'admin' => 0],
            ['name' => 'Della Jonata', 'email' => 'dellajhonata@gmail.com', 'password' => Hash::make('sektoralbatam'), 'admin' => 0],
            ['name' => 'Firdaus Oktayudintono', 'email' => 'firdausfirdaus85@gmail.com', 'password' => Hash::make('sektoralbatam'), 'admin' => 0],
            ['name' => 'Selvi Deliana', 'email' => 'selvideliana21@gmail.com', 'password' => Hash::make('sektoralbatam'), 'admin' => 0],
            ['name' => 'renata', 'email' => 'renata@gmail.com', 'password' => Hash::make('renata'), 'admin' => 1],
            ['name' => 'user', 'email' => 'user@gmail.com', 'password' => Hash::make('user'), 'admin' => 0],
            ['name' => 'Eko Aprianto, SST, M.T.I.', 'email' => 'e_aprianto@bps.go.id', 'password' => Hash::make('340016186'), 'admin' => 1],
            ['name' => 'Desmaini, S.Si', 'email' => 'desmaini@bps.go.id', 'password' => Hash::make('340016709'), 'admin' => 1],
            ['name' => 'Adi Darmanto, S.E.', 'email' => 'adi.darmanto@bps.go.id', 'password' => Hash::make('340054823'), 'admin' => 1],
            ['name' => 'Retza Bahtiar Anugrah, S.Si.', 'email' => 'retza.anugrah@bps.go.id', 'password' => Hash::make('340059217'), 'admin' => 1],
            ['name' => 'Renata Putri Henessa, S.Tr.Stat.', 'email' => 'putri.henessa@bps.go.id', 'password' => Hash::make('340062664'), 'admin' => 1],
            ['name' => 'Adlina Khairunnisa, SST', 'email' => 'adlina.khairunnisa@bps.go.id', 'password' => Hash::make('340057261'), 'admin' => 1],
            ['name' => 'Evawane Fahma Kusumawardani, S.Tr.Stat', 'email' => 'evawane.fahma@bps.go.id', 'password' => Hash::make('340059510'), 'admin' => 1],
            ['name' => 'Ivana Yoselin Purba Siboro, S.Tr.Stat.', 'email' => 'yoselin.purba@bps.go.id', 'password' => Hash::make('340060699'), 'admin' => 1],
            ['name' => 'Ratih Nurhabibah, S.Tr.Stat.', 'email' => 'ratihnurhabibah@bps.go.id', 'password' => Hash::make('340060871'), 'admin' => 1],
            ['name' => 'Florentz Magdalena', 'email' => 'fmagdalena@bps.go.id', 'password' => Hash::make('340056837'), 'admin' => 1],
            ['name' => 'Maulidya Fan Ghul Udzan Utami', 'email' => 'maulidfan.ghul@bps.go.id', 'password' => Hash::make('340063310'), 'admin' => 1],

        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
