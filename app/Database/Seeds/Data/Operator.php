<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Operator extends Seeder
{
    public function run()
    {
        //
        //
        $model = model('App\Models\Operator', false);
        $data = [
            ['operator' => 'Debe'],
            ['operator' => 'Haber']
        ];
        foreach ($data as $key) {
            $user = new \App\Entities\Operator($key);
            $model->insert($user);
        }
    }
}
