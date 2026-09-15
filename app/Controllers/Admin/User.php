<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ActivityLogModel;

class User extends BaseController
{
    protected $userModel;
    protected $activityLogModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->activityLogModel = new ActivityLogModel();
    }

    public function index()
    {
        $users = $this->userModel->paginate(10);
        $pager = $this->userModel->pager;

        return view('admin/users/index', [
            'users' => $users,
            'pager' => $pager,
        ]);
    }

    public function create()
    {
        return view('admin/users/create');
    }

    public function store()
    {
        $data = [
            'username' => $this->request->getPost('username'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role' => $this->request->getPost('role') ?? 'user',
            'status' => 'active',
        ];

        if ($this->userModel->insert($data)) {
            $this->activityLogModel->log(session()->get('user_id'), 'CREATE_USER', 'Tambah user: ' . $data['username']);
            return redirect()->to(site_url('admin/users'))->with('success', 'User berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan user.');
        }
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(site_url('admin/users'))->with('error', 'User tidak ditemukan.');
        }

        return view('admin/users/edit', ['user' => $user]);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(site_url('admin/users'))->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
        ];

        // Only update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }

        if ($this->userModel->update($id, $data)) {
            $this->activityLogModel->log(session()->get('user_id'), 'UPDATE_USER', 'Edit user: ' . $user['username']);
            return redirect()->to(site_url('admin/users'))->with('success', 'User berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui user.');
        }
    }

    public function delete($id)
    {
        // Prevent deleting own account
        if ($id == session()->get('user_id')) {
            return redirect()->to(site_url('admin/users'))->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(site_url('admin/users'))->with('error', 'User tidak ditemukan.');
        }

        if ($this->userModel->delete($id)) {
            $this->activityLogModel->log(session()->get('user_id'), 'DELETE_USER', 'Hapus user: ' . $user['username']);
            return redirect()->to(site_url('admin/users'))->with('success', 'User berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus user.');
        }
    }
}
