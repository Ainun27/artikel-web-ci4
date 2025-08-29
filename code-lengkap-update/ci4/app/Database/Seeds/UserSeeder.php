<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'     => 'admin',
            'useremail'    => 'admin@email.com',
            'userpassword' => password_hash('abc', PASSWORD_DEFAULT), // HASHED!
        ];

        // Insert data ke tabel user
        $this->db->table('user')->insert($data);
    }
}
