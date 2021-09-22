<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Errors extends BaseController
{
    public function index()
    {
        $config = [
            'page' => [
                'title' => 'Error 404',
                'file' => '404NotFound',
                'name' => 'ERP'
            ]
        ];
        $data = array_map(function ($array) {
            return (object)$array;
        }, $config);
        if (!session()->get('isLoggedIn')) {
            echo view('errors/views/isnt_logged_404', $data);
        } else {
            echo view('errors/views/is_logged_404', $data);
        }
    }
}
