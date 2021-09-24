<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Accounts extends ResourceController
{
    public function __construct()
    {
        $this->model = model('App\Models\Accounts', false);
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
                'input-code' => 'required',
                'input-account' => 'required|is_unique[accounts.account]',
                'input-type' => 'required'
            ))) {
                $data = [
                    'code'      =>  $this->request->getPost('input-code'),
                    'type_fk'   =>  $this->request->getPost('input-type'),
                    'account'   =>  $this->request->getPost('input-account')
                ];
                $account = new \App\Entities\Accounts($data);
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
                'input-code' => 'required',
                'input-account' => 'required|is_unique[accounts.account,id,{id}]',
                'input-type' => 'required'
            ))) {
                $data = [
                    'id'      =>  $this->request->getPost('id'),
                    'code'      =>  $this->request->getPost('input-code'),
                    'type_fk'   =>  $this->request->getPost('input-type'),
                    'account'   =>  $this->request->getPost('input-account')
                ];
                $account = new \App\Entities\Accounts($data);
                if ($this->model->save($account)) {
                    return $this->respondUpdated(array(
                        'message' => 'updated'
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
