<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Transactions extends BaseController
{
    public function index()
    {
        return view('admin/transactions/index');
    }
}