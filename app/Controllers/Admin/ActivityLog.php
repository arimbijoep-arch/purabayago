<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ActivityLogModel;

class ActivityLog extends BaseController
{
    protected $activityLogModel;

    public function __construct()
    {
        $this->activityLogModel = new ActivityLogModel();
    }

    public function index()
    {
        $logs = $this->activityLogModel->getWithUser();
        $pager = $this->activityLogModel->pager;

        return view('admin/logs/index', [
            'logs' => $logs,
            'pager' => $pager,
        ]);
    }
}
