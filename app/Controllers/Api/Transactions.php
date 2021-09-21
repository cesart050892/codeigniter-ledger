<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Transactions extends ResourceController
{
    public function index()
    {
        //
        return $this->respond(array(
            'message' => 'Transaction page'
        ));
    }
}
