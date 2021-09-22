<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        //
        //
        $model = model('App\Models\Users', false);
        $data = [
            [
                'name' => 'unknow',
                'surname' => 'empty',
                'email' => 'whoami@email.com',
                'username' => 'whoami',
                'password' => 'admin'
            ],
        ];
        foreach ($data as $key) {
            $user = new \App\Entities\Users($key);
            $model->insert($user);
        }
    }
}
