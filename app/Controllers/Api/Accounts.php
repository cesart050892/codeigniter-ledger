<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Accounts extends ResourceController
{
    public function __construct()
    {
        $this->model = model('App\Models\Accounts', false);
    }

    function index(){
        try {
            $users = $this->model->getAll();
            return $this->respond(array(
                'data'    => $users
            ));
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }
}