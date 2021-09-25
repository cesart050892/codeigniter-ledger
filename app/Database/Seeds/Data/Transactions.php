<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Transactions extends Seeder
{
    public function run()
    {
        //
        //
        $model = model('App\Models\Transactions', false);
        $data = [
            [
                'transaction' => 'TR001',
                'quantity'    => '5000',
                'description' => 'Inversion inicial',
                'account_fk' => 1,
                'operator_fk' => 1
            ],
        ];
        foreach ($data as $key) {
            $user = new \App\Entities\Transactions($key);
            $model->insert($user);
        }
    }
}
