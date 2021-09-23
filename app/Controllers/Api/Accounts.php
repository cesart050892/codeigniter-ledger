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
            $res = $this->model->getAll();
            return $this->respond(array(
                'data'    => $res
            ));
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    function delete($id = null){
        try {
            if ($this->model->delete($id)) {
                $this->model->purgeDeleted();
                return $this->respond(array(
                    'message'    => 'deleted'
                ));
            } else {
                return $this->fail($this->model->errors());
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function edit($id = null)
    {
        try {
            if ($resp = $this->model->getOne($id)) {
                return $this->respond(array(
                    'data'    => $resp
                ));
            } else {
                return $this->failNotFound('can\'t be no found it');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }
}