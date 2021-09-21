<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Home extends ResourceController
{
    public function index()
    {
        //
        return $this->respond(array(
            'message' => 'Welcome to ledger app'
        ));
    }
}
