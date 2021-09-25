<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Nature extends ResourceController
{
    public function __construct()
    {
        $this->model = model('App\Models\Nature', false);
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