<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        $this->call('KategoriSeeder');
        $this->call('ArtikelSeeder');
        $this->call('UserSeeder');
    }
}
