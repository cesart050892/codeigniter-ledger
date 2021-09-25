<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Nature extends Seeder
{
    public function run()
    {
        //
        //
        $model = model('App\Models\Nature', false);
        $data = [
            [
                'nature' => 'Activo',
                'code' => 1
            ],
            [
                'nature' => 'Pasivo',
                'code' => 2
            ],
            [
                'nature' => 'Capital',
                'code' => 3
            ]
        ];
        foreach ($data as $key) {
            $user = new \App\Entities\Nature($key);
            $model->insert($user);
        }
    }
}
