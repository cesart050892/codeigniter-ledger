<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        return view('admin/auth/login');
    }
}