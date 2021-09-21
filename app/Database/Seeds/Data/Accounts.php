<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Accounts extends Seeder
{
    public function run()
    {
        //
        //
        $model = model('App\Models\Accounts', false);
        $data = [
            [
                'account' => 'Caja',
                'code' => 1,
                'type_fk' => 1
            ],
            [
                'account' => 'Proveedores',
                'code' => 1,
                'type_fk' => 2
            ],
        ];
        foreach ($data as $key) {
            $user = new \App\Entities\Accounts($key);
            $model->insert($user);
        }
    }
}
