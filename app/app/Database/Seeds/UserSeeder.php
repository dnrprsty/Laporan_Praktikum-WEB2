<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $payload = [
            'username'     => 'admin',
            'useremail'    => 'admin@email.com',
            'userpassword' => password_hash('admin123', PASSWORD_DEFAULT),
        ];

        $existing = $this->db->table('user')
            ->where('useremail', $payload['useremail'])
            ->get()
            ->getFirstRow('array');

        if ($existing === null) {
            $this->db->table('user')->insert($payload);
            return;
        }

        $this->db->table('user')->where('id', $existing['id'])->update($payload);
    }
}
