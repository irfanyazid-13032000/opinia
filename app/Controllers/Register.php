<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class Register extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        helper(['form']);
        $rules = [
            'fullname' => 'required|is_unique[users.fullname]',
            'phone' => 'required|is_unique[users.phone]',
            'email' => 'required|is_unique[users.email]|valid_email',
            'password' => 'required'
        ];
        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $data = [
            'fullname' => $this->request->getVar('fullname'),
            'phone' => $this->request->getVar('phone'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)
        ];
        $model = new UserModel();
        $model->save($data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'user registered'
            ]
        ];
        return $this->respond($response);
    }
}
