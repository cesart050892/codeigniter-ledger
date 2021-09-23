<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Accounts extends BaseController
{
    public function index()
    {
        return view('admin/account/index');
    }
}