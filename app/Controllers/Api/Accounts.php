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
}