<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ImageUploader;
use App\Models\ActivityLogModel;
use App\Models\BusModel;
use App\Models\DestinationModel;

class Bus extends BaseController
{
    protected $busModel;
    protected $destinationModel;
    protected $activityLogModel;
    protected $imageUploader;

    public function __construct()
    {
        $this->busModel = new BusModel();
        $this->destinationModel = new DestinationModel();
        $this->activityLogModel = new ActivityLogModel();
        $this->imageUploader = new ImageUploader();
    }

    public function index()
    {
        $buses = $this->busModel
            ->select('bus.*, destinations.destination_name')
            ->join('destinations', 'destinations.id = bus.destination_id', 'left')
            ->paginate(10);

        return view('admin/bus/index', [
            'buses' => $buses,
            'pager' => $this->busModel->pager,
        ]);
    }

    public function create()
    {
        return view('admin/bus/create', [
            'destinations' => $this->destinationModel->findAll(),
            'shelters' => $this->busModel->getShelters(),
        ]);
    }

    public function store()
    {
        $photo = $this->imageUploader->upload($this->request->getFile('photo'), 'bus');
        if ($photo === false) {
            return redirect()->back()->withInput()->with('error', 'Foto harus JPG, JPEG, PNG, WEBP, maksimal 2 MB.');
        }

        $data = $this->busData();
        $data['photo'] = $photo;

        if ($this->busModel->insert($data)) {
            $this->busModel->syncSchedules((int) $this->busModel->getInsertID(), $this->request->getPost('schedule_times'), $this->request->getPost('schedule_status'), $this->request->getPost('frequency'), $this->request->getPost('schedule_note'));
            $this->activityLogModel->log(session()->get('user_id'), 'CREATE_BUS', 'Tambah bus: ' . $data['operator']);
            return redirect()->to(site_url('admin/bus'))->with('success', 'Bus berhasil ditambahkan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan bus.');
    }

    public function edit($id)
    {
        $bus = $this->busModel->find($id);
        if (!$bus) {
            return redirect()->to(site_url('admin/bus'))->with('error', 'Bus tidak ditemukan.');
        }

        return view('admin/bus/edit', [
            'bus' => $bus,
            'destinations' => $this->destinationModel->findAll(),
            'shelters' => $this->busModel->getShelters(),
            'schedules' => $this->busModel->getScheduleInput((int) $id),
        ]);
    }

    public function update($id)
    {
        $bus = $this->busModel->find($id);
        if (!$bus) {
            return redirect()->to(site_url('admin/bus'))->with('error', 'Bus tidak ditemukan.');
        }

        $photo = $this->imageUploader->upload($this->request->getFile('photo'), 'bus');
        if ($photo === false) {
            return redirect()->back()->withInput()->with('error', 'Foto harus JPG, JPEG, PNG, WEBP, maksimal 2 MB.');
        }

        $data = $this->busData();
        if ($photo !== null) {
            $data['photo'] = $photo;
        }

        if ($this->busModel->update($id, $data)) {
            $this->busModel->syncSchedules((int) $id, $this->request->getPost('schedule_times'), $this->request->getPost('schedule_status'), $this->request->getPost('frequency'), $this->request->getPost('schedule_note'));
            if ($photo !== null && !empty($bus['photo'])) {
                $this->imageUploader->delete('bus', $bus['photo']);
            }

            $this->activityLogModel->log(session()->get('user_id'), 'UPDATE_BUS', 'Edit bus: ' . $data['operator']);
            return redirect()->to(site_url('admin/bus'))->with('success', 'Bus berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal memperbarui bus.');
    }

    public function delete($id)
    {
        $bus = $this->busModel->find($id);
        if (!$bus) {
            return redirect()->to(site_url('admin/bus'))->with('error', 'Bus tidak ditemukan.');
        }

        if ($this->busModel->delete($id)) {
            if (!empty($bus['photo'])) {
                $this->imageUploader->delete('bus', $bus['photo']);
            }

            $this->activityLogModel->log(session()->get('user_id'), 'DELETE_BUS', 'Hapus bus: ' . $bus['operator']);
            return redirect()->to(site_url('admin/bus'))->with('success', 'Bus berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Gagal menghapus bus.');
    }

    private function busData(): array
    {
        $scheduleTimes = array_filter(array_map('trim', explode(',', (string) $this->request->getPost('schedule_times'))));
        $legacyDepartureTime = $scheduleTimes[0] ?? '06:00';
        $legacyDepartureTime = str_replace('.', ':', $legacyDepartureTime);
        if (strlen($legacyDepartureTime) === 5) {
            $legacyDepartureTime .= ':00';
        }
        $fare = $this->parseFare($this->request->getPost('fare'));
        $fareMaxInput = $this->request->getPost('fare_max');
        $fareMax = $fareMaxInput === null || trim((string) $fareMaxInput) === '' ? $fare : $this->parseFare($fareMaxInput);

        return [
            'operator' => $this->request->getPost('operator'),
            'photo_alt' => $this->request->getPost('photo_alt') ?: 'Bus ' . $this->request->getPost('operator'),
            'photo_caption' => $this->request->getPost('photo_caption'),
            'destination_id' => $this->request->getPost('destination_id'),
            'shelter_id' => $this->request->getPost('shelter_id') ?: null,
            'bus_class' => $this->request->getPost('bus_class'),
            'departure_time' => $legacyDepartureTime,
            'fare' => $fare,
            'fare_max' => $fareMax,
            'departure_area' => $this->request->getPost('departure_area'),
            'ticket_information' => $this->request->getPost('ticket_information'),
            'description' => $this->request->getPost('description'),
            'quantity' => $this->request->getPost('quantity') ?? 1,
            'capacity' => $this->request->getPost('capacity') ?? 40,
            'status' => $this->request->getPost('status') ?? 'aktif',
            'last_updated' => date('Y-m-d H:i:s'),
        ];
    }

    private function parseFare($value): int
    {
        $value = trim((string) $value);
        if ($value === '') {
            return 0;
        }

        return (int) preg_replace('/[^0-9]/', '', $value);
    }

}
