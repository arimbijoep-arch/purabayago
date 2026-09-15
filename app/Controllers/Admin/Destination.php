<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ImageUploader;
use App\Models\DestinationModel;
use App\Models\ActivityLogModel;

class Destination extends BaseController
{
    protected $destinationModel;
    protected $activityLogModel;
    protected $imageUploader;

    public function __construct()
    {
        $this->destinationModel = new DestinationModel();
        $this->activityLogModel = new ActivityLogModel();
        $this->imageUploader = new ImageUploader();
    }

    public function index()
    {
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $destinations = $this->destinationModel->paginate(10, 'default', $page);
        $pager = $this->destinationModel->pager;

        return view('admin/destination/index', [
            'destinations' => $destinations,
            'pager' => $pager,
            'page' => $page,
        ]);
    }

    public function create()
    {
        return view('admin/destination/create');
    }

    public function store()
    {
        $photo = $this->imageUploader->upload($this->request->getFile('photo'), 'destinations');
        if ($photo === false) {
            return redirect()->back()->withInput()->with('error', 'Foto gagal diunggah. Gunakan JPG, PNG, atau WebP maksimal 2 MB.');
        }

        $data = [
            'destination_name' => $this->request->getPost('destination_name'),
            'description' => $this->request->getPost('description'),
            'photo' => $photo,
            'photo_alt' => $this->request->getPost('photo_alt') ?: 'Kota ' . $this->request->getPost('destination_name'),
            'photo_caption' => $this->request->getPost('photo_caption'),
        ];

        if ($this->destinationModel->insert($data)) {
            $this->activityLogModel->log(session()->get('user_id'), 'CREATE_DESTINATION', 'Tambah tujuan: ' . $data['destination_name']);
            return redirect()->to(site_url('admin/destination'))->with('success', 'Tujuan berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan tujuan.');
        }
    }

    public function edit($id)
    {
        $destination = $this->destinationModel->find($id);
        if (!$destination) {
            return redirect()->to(site_url('admin/destination'))->with('error', 'Tujuan tidak ditemukan.');
        }

        return view('admin/destination/edit', [
            'destination' => $destination,
            'page' => max(1, (int) ($this->request->getGet('page') ?? 1)),
        ]);
    }

    public function update($id)
    {
        $destination = $this->destinationModel->find($id);
        if (!$destination) {
            return redirect()->to(site_url('admin/destination'))->with('error', 'Tujuan tidak ditemukan.');
        }

        $page = max(1, (int) ($this->request->getPost('page') ?? 1));
        $destinationUrl = site_url('admin/destination') . '?page=' . $page;
        $photo = $this->imageUploader->upload($this->request->getFile('photo'), 'destinations');
        if ($photo === false) {
            return redirect()->back()->withInput()->with('error', 'Foto gagal diunggah. Gunakan JPG, PNG, atau WebP maksimal 2 MB.');
        }

        $data = [
            'destination_name' => $this->request->getPost('destination_name'),
            'description' => $this->request->getPost('description'),
            'photo_alt' => $this->request->getPost('photo_alt') ?: 'Kota ' . $this->request->getPost('destination_name'),
            'photo_caption' => $this->request->getPost('photo_caption'),
        ];
        if ($photo !== null) {
            $data['photo'] = $photo;
        }

        if ($this->destinationModel->update($id, $data)) {
            if ($photo !== null) {
                $this->imageUploader->delete('destinations', $destination['photo'] ?? null);
            }
            $this->activityLogModel->log(session()->get('user_id'), 'UPDATE_DESTINATION', 'Edit tujuan: ' . $data['destination_name']);
            return redirect()->to($destinationUrl)->with('success', 'Tujuan berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui tujuan.');
        }
    }

    public function delete($id)
    {
        $destination = $this->destinationModel->find($id);
        if (!$destination) {
            return redirect()->to(site_url('admin/destination'))->with('error', 'Tujuan tidak ditemukan.');
        }

        // Check if destination has buses
        $busModel = new \App\Models\BusModel();
        $busCounts = $busModel->countBy('destination_id', $id);
        if ($busCounts > 0) {
            return redirect()->to(site_url('admin/destination'))->with('error', 'Tidak dapat menghapus tujuan yang masih memiliki bus. Hapus bus terlebih dahulu.');
        }

        if ($this->destinationModel->delete($id)) {
            $this->imageUploader->delete('destinations', $destination['photo'] ?? null);
            $this->activityLogModel->log(session()->get('user_id'), 'DELETE_DESTINATION', 'Hapus tujuan: ' . $destination['destination_name']);
            return redirect()->to(site_url('admin/destination'))->with('success', 'Tujuan berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus tujuan.');
        }
    }
}
