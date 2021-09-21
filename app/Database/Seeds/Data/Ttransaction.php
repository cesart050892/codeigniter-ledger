<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Ttransaction extends Seeder
{
    public function run()
    {
        //
        //
        $model = model('App\Models\Ttransaction', false);
        $data = [
            ['type-transaction' => 'debe'],
            ['type-transaction' => 'haber']
        ];
        foreach ($data as $key) {
            $user = new \App\Entities\Ttransaction($key);
            $model->insert($user);
        }
    }
}
