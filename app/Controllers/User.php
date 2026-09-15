<?php

namespace App\Controllers;

use App\Models\BusModel;
use App\Models\DestinationModel;
use App\Models\UserModel;
use App\Models\SettingModel;

class User extends BaseController
{
    public function dashboard()
    {
        $destinationModel = new DestinationModel();
        $busModel = new BusModel();
        $destinations = $destinationModel->findAll();
        $featuredDestinations = [];

        foreach (array_slice($destinations, 0, 6) as $destination) {
            $summary = $busModel
                ->select('COUNT(*) AS bus_count, MIN(fare) AS min_fare')
                ->where('destination_id', $destination['id'])
                ->first();

            $featuredDestinations[] = [
                ...$destination,
                'bus_count' => (int) ($summary['bus_count'] ?? 0),
                'min_fare' => $summary['min_fare'] ?? null,
            ];
        }

        $todayDepartures = $busModel
            ->select('bus.*, destinations.destination_name, bus_schedules.departure_time AS scheduled_time')
            ->join('destinations', 'destinations.id = bus.destination_id', 'left')
            ->join('bus_schedules', 'bus_schedules.bus_id = bus.id', 'left')
            ->where('bus_schedules.departure_time IS NOT NULL', null, false)
            ->orderBy('bus_schedules.departure_time', 'ASC')
            ->findAll(4);
        $user = (new UserModel())->find(session()->get('user_id'));
        $settings = new SettingModel();

        return view('user/dashboard', [
            'user' => $user,
            'featuredDestinations' => $featuredDestinations,
            'todayDepartures' => $todayDepartures,
            'logoImage' => $settings->getValue('logo_image'),
            'logoAlt' => $settings->getValue('logo_alt', 'PURABAYA GO'),
        ]);
    }

    public function profile()
    {
        $userModel = new UserModel();
        $user = $userModel->find(session()->get('user_id'));

        return view('user/profile', ['user' => $user]);
    }

    public function updateProfile()
    {
        $userModel = new UserModel();
        $id = session()->get('user_id');

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
        ];

        if (! empty($this->request->getFile('foto_profil')->getName())) {
            $file = $this->request->getFile('foto_profil');
            if ($file->isValid() && ! $file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/profile', $newName);
                $data['foto_profil'] = 'uploads/profile/' . $newName;
            }
        }

        $userModel->update($id, $data);
        session()->setFlashdata('success', 'Profil berhasil diperbarui.');

        return redirect()->to(site_url('user/profile'));
    }

    public function updatePassword()
    {
        $userModel = new UserModel();
        $id = session()->get('user_id');
        $newPassword = $this->request->getPost('password');

        if (empty($newPassword)) {
            session()->setFlashdata('error', 'Password baru wajib diisi.');
            return redirect()->to(site_url('user/profile'));
        }

        $userModel->update($id, ['password' => $newPassword]);
        session()->setFlashdata('success', 'Password berhasil diperbarui.');

        return redirect()->to(site_url('user/profile'));
    }
}
