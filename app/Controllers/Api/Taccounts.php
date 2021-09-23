<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class TAccounts extends ResourceController
{
    public function __construct()
    {
        $this->model = model('App\Models\Taccount', false);
    }

    function index(){
        try {
            $res = $this->model->findAll();
            return $this->respond(array(
                'data'    => $res
            ));
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }
}