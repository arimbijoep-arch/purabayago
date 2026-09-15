<?php

namespace App\Controllers;

use App\Models\BusModel;

class Bus extends BaseController
{
    public function detail($id)
    {
        $busModel = new BusModel();
        $bus = $busModel->getBusDetail((int) $id);

        if (empty($bus)) {
            return redirect()->to('/search')->with('error', 'Bus tidak ditemukan.');
        }

        return view('bus/detail', ['bus' => $bus]);
    }
}
