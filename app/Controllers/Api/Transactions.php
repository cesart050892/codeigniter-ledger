<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Transactions extends ResourceController
{
    public function __construct()
    {
        $this->model = model('App\Models\Transactions', false);
    }

    function index()
    {
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

    function delete($id = null)
    {
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

    public function create()
    {
        try {
            //
            if ($this->validate(array(
                'account'       => 'required|numeric',
                'operator'      => 'required|numeric',
                'quantity'      => 'required|decimal',
                'description'   => 'required'
            ))) {
                $data = [
                    'transaction'       => '',
                    'account_fk'        =>  $this->request->getPost('account'),
                    'operator_fk'       =>  $this->request->getPost('operator'),
                    'quantity'          =>  $this->request->getPost('quantity'),
                    'description'       =>  $this->request->getPost('description'),
                ];
                $account = new \App\Entities\Transactions($data);
                if ($this->model->save($account)) {
                    return $this->respondCreated(array(
                        'message' => 'created'
                    ));
                } else {
                    return $this->failValidationErrors($this->model->validator->getErrors());
                }
            } else {
                return $this->failValidationErrors($this->validator->getErrors());
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function update($id = null)
    {
        try {
            //
            if ($this->validate(array(
                'account'       => 'required|numeric',
                'operator'      => 'required|numeric',
                'quantity'      => 'required|decimal',
                'description'   => 'required'
            ))) {
                $data = [
                    'id'            => $id,
                    'account_fk'    =>  $this->request->getPost('account'),
                    'operator_fk'   =>  $this->request->getPost('operator'),
                    'quantity'      =>  $this->request->getPost('quantity'),
                    'description'   =>  $this->request->getPost('description'),
                ];
                $account = new \App\Entities\Transactions($data);
                if ($this->model->save($account)) {
                    return $this->respondCreated(array(
                        'message' => 'created'
                    ));
                } else {
                    return $this->failValidationErrors($this->model->validator->getErrors());
                }
            } else {
                return $this->failValidationErrors($this->validator->getErrors());
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

}
