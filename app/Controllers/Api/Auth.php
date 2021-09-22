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

    public function login()
    {
        //
        try {
            $rules_income = [ // Rules validations
                'username' => 'required',
                'password' => 'required|min_length[4]', //validate_user[username,password]
            ];
            if ($this->validate($rules_income)) { // Execute validation
                $data = [$this->request->getVar('username'), $this->request->getVar('password')];
                $user = $this->model->where('username', $data[0])->first(); // Verify exist username
                if ($user == null) return $this->fail('This user no exist!');
                if (password_verify($data[1], $user->password)) { // Verify password
                    $userModel = model('App\Models\Users', false);
                    $user = $userModel->getOne($user->id);
                    $session_data = [ // Session data
                        'base_url'  => base_url(),
                        'user_name' => $user->name,
                        'user_username' => $user->username,
                        'user_id' => $user->id,
                        'isLoggedIn' => true
                    ];
                    session()->set($session_data);
                    return $this->respond([
                        'status' => 200,
                        'message' => 'logged in',
                        'data' => [
                            'username' => $user->username,
                            'name' =>  $user->name,
                            'created_at' => $user->created_at->humanize(),
                        ]
                    ], 200);
                } else {
                    return $this->failValidationErrors('Invalid password');
                }
            } else {
                return $this->fail($this->validator->getErrors());
            }
        } catch (\Throwable $e) {
            //throw $e;
            return $this->failServerError($e->getMessage());
        }
    }
}
