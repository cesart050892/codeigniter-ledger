<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Taccount extends Seeder
{
    public function run()
    {
        //
        //
        $model = model('App\Models\Taccount', false);
        $data = [
            [
                'type-account' => 'Activo',
                'code' => 1
            ],
            [
                'type-account' => 'Pasivo',
                'code' => 2
            ],
            [
                'type-account' => 'Capital',
                'code' => 3
            ]
        ];
        foreach ($data as $key) {
            $user = new \App\Entities\Taccount($key);
            $model->insert($user);
        }
    }
}
