<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function login()
    {
        if (! $this->request->is('post')) {
            return view('user/login', $this->pageData([
                'title' => 'Login Admin',
            ]));
        }

        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');
        $user = (new UserModel())->where('useremail', $email)->first();

        if ($user === null || ! password_verify($password, $user['userpassword'])) {
            session()->setFlashdata('error', 'Email atau password tidak sesuai.');

            return redirect()->to('/user/login');
        }

        session()->set([
            'user_id'    => $user['id'],
            'user_name'  => $user['username'],
            'user_email' => $user['useremail'],
            'logged_in'  => true,
        ]);

        return redirect()->to('/admin/artikel');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/user/login');
    }
}
