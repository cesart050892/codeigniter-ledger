<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    public function __construct()
    {
        $this->model = model('App\Models\Auth', false);
    }

    public function signup()
    {
        try {
            if ($this->validate(array(
                'name' => 'required',
                'email' => 'required|valid_email|is_unique[auth.email]',
                'username' => 'required|is_unique[auth.username]',
                'password' => 'required',
                'pass_confirm' => 'required|matches[password]'
            ))) { // Execute validation
                $data = [
                    "email"        => $this->request->getVar("email"),
                    "username"    => $this->request->getVar("username"),
                    "password"    => $this->request->getVar("password"),
                ];
                $credentials = new \App\Entities\Auth($data);
                if ($this->model->save($credentials)) {
                    $data = [
                        "name"    => $this->request->getVar("name"),
                        "credential_fk"   => $this->model->insertID()
                    ];
                    $userModel = model('App\Models\Users', false);
                    $user = new \App\Entities\Users($data);
                    if ($userModel->save($user)) {
                        return $this->respond(array(
                            "status"    => 200,
                            "message"     => "Welcome! " . $user->name,
                            "data"        => [
                                "username"     => $credentials->username,
                                "email"        => $credentials->email
                            ]
                        ));
                    } else {
                        return $this->fail($userModel->validator->getErrors());
                    }
                } else {
                    return $this->fail($this->model->validator->getErrors());
                }
            } else {
                return $this->fail($this->validator->getErrors());
            }
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
