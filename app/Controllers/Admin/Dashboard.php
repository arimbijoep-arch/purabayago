<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BusModel;
use App\Models\DestinationModel;
use App\Models\UserModel;
use App\Models\ActivityLogModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $busModel = new BusModel();
        $destinationModel = new DestinationModel();
        $userModel = new UserModel();
        $activityLogModel = new ActivityLogModel();

        $stats = [
            'total_bus' => $busModel->countAll(),
            'total_destination' => $destinationModel->countAll(),
            'total_users' => $userModel->countAll(),
            'total_admins' => $userModel->where('role', 'admin')->countAllResults(),
        ];

        $busPerDestination = $busModel
            ->select('destinations.destination_name, COUNT(bus.id) as count')
            ->join('destinations', 'destinations.id = bus.destination_id', 'left')
            ->groupBy('bus.destination_id')
            ->orderBy('count', 'DESC')
            ->findAll();

        $busPerCategory = $busModel
            ->select('bus_class, COUNT(id) as count')
            ->groupBy('bus_class')
            ->findAll();

        $recentLogs = $activityLogModel
            ->select('activity_logs.*, users.username, users.nama_lengkap')
            ->join('users', 'users.id = activity_logs.user_id', 'left')
            ->orderBy('activity_logs.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        return view('admin/dashboard', [
            'title' => '',
            'stats' => $stats,
            'busPerDestination' => $busPerDestination,
            'busPerCategory' => $busPerCategory,
            'recentLogs' => $recentLogs,
        ]);
    }
}
