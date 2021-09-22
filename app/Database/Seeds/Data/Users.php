<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        //
        //
        $authModel = model('App\Models\Auth', false);
        $credentials = [
            [
                'username' => 'admin',
                'email'    => 'admin@email.com',
                'password' => 'admin'
            ],
        ];
        foreach ($credentials as $credential) {
            $credential = new \App\Entities\Auth($credential);
            $authModel->insert($credential);
        }

        $userModel = model('App\Models\Users', false);
        $users = [
            [
                'name' => 'admin',
                'address'    => 'admin@email.com',
                'phone' => 'admin',
                'credential_fk' => $authModel->insertID()
            ],
        ];
        foreach ($users as $user) {
            $credential = new \App\Entities\Users($user);
            $userModel->insert($credential);
        }
    }
}
