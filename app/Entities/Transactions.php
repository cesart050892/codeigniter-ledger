<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Transactions extends Entity
{
    protected $datamap = [];
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts   = [];

    protected function setTransaction(string $password)
    {
        $data = model('App\Models\Transactions', false);
        if ($result = $data->getLast()) {
            list($suffix, $patron, $number) = explode(00, $result->transaction);
            $this->attributes['transaction'] = $suffix . "00" . ($number + 1);
        } else {
            $this->attributes['transaction'] = 'TR001';
        }
        return $this;
    }
}
