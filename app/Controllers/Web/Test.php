<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Test extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            'field' => !empty($this->request->getVar('field')),
            'image' => !empty($this->request->getVar('image'))
        ]);
    }
}