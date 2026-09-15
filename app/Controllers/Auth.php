<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function loginPage()
    {
        return view('auth/login');
    }

    public function registerPage()
    {
        return view('auth/register');
    }

    public function register()
    {
        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role' => 'user',
            'status' => 'active',
        ];

        if (! $userModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        session()->setFlashdata('success', 'Registrasi berhasil. Silakan login untuk melanjutkan.');
        return redirect()->to(site_url('login'));
    }

    public function login()
    {
        $identity = $this->request->getPost('identity');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->login($identity, $password);

        if (! $user) {
            $account = (new UserModel())
                ->groupStart()
                ->where('username', $identity)
                ->orWhere('email', $identity)
                ->groupEnd()
                ->first();

            if ($account && $account['status'] === 'inactive') {
                session()->setFlashdata('error', 'Akun Anda belum aktif. Hubungi admin untuk informasi lebih lanjut.');
            } else {
                session()->setFlashdata('error', 'Login gagal. Username/email atau password salah.');
            }
            return redirect()->back()->withInput();
        }

        session()->set([
            'logged_in' => true,
            'user_id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'nama_lengkap' => $user['nama_lengkap'],
        ]);

        session()->setFlashdata('success', 'Login berhasil.');

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        $intendedUrl = session()->get('intended_url');
        session()->remove('intended_url');
        if (is_string($intendedUrl) && $intendedUrl !== '' && ! str_starts_with($intendedUrl, '/admin')) {
            return redirect()->to($intendedUrl);
        }

        return redirect()->to('/user/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Logout berhasil.');
        return redirect()->to('/login');
    }
}
