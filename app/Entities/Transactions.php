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
        $result = $data->getLast();
        $res = explode(00, $result->transaction);
        $this->attributes['transaction'] = $res[0]."00".($res[2]+1);
		return $this;
	}
}
