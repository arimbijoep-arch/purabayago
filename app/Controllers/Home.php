<?php

namespace App\Controllers;

use App\Models\BusModel;
use App\Models\DestinationModel;
use App\Models\SettingModel;

class Home extends BaseController
{
    public function index(): string
    {
        $destinationModel = new DestinationModel();
        $busModel = new BusModel();
        $settingModel = new SettingModel();
        $destinations = [];
        $featuredDestinations = [];
        $todayDepartures = [];
        $logoImage = null;
        $logoAlt = 'PURABAYA GO';
        $heroImage = null;
        $heroAlt = 'Bus keberangkatan dari Terminal Purabaya';
        $terminalImage = null;
        $terminalAlt = 'Terminal Purabaya Bungurasih';

        try {
            $isServerless = (bool) env('VERCEL', false);

            if (!$isServerless && session()->get('logged_in')) {
                $destinations = $destinationModel->findAll();

                foreach ($destinations as $destination) {
                    $summary = $busModel
                        ->select('COUNT(*) AS bus_count, MIN(fare) AS min_fare')
                        ->where('destination_id', $destination['id'])
                        ->first();
                    $categories = $busModel
                        ->select('bus_class')
                        ->distinct()
                        ->where('destination_id', $destination['id'])
                        ->orderBy('bus_class', 'ASC')
                        ->findAll();

                    $featuredDestinations[] = [
                        ...$destination,
                        'bus_count' => (int) ($summary['bus_count'] ?? 0),
                        'min_fare' => $summary['min_fare'] ?? null,
                        'categories' => array_column($categories, 'bus_class'),
                    ];
                }

                $todayDepartures = $busModel
                    ->select('bus.*, destinations.destination_name, shelters.shelter_number, bus_schedules.departure_time AS scheduled_time, bus_schedules.schedule_status')
                    ->join('destinations', 'destinations.id = bus.destination_id', 'left')
                    ->join('shelters', 'shelters.id = bus.shelter_id', 'left')
                    ->join('bus_schedules', 'bus_schedules.bus_id = bus.id', 'left')
                    ->where('bus_schedules.departure_time IS NOT NULL', null, false)
                    ->orderBy('bus_schedules.departure_time', 'ASC')
                    ->findAll(6);
            }

            if (!$isServerless) {
                $logoImage = $settingModel->getValue('logo_image');
                $logoAlt = $settingModel->getValue('logo_alt', $logoAlt);
                $heroImage = $settingModel->getValue('hero_image');
                $heroAlt = $settingModel->getValue('hero_alt', $heroAlt);
                $terminalImage = $settingModel->getValue('terminal_image');
                $terminalAlt = $settingModel->getValue('terminal_alt', $terminalAlt);
            }
        } catch (\Throwable $exception) {
            if (ENVIRONMENT !== 'production') {
                throw $exception;
            }
        }

        $data = [
            'title' => 'PURABAYA GO',
            'tagline' => 'Temukan Busmu, Mulai Perjalananmu.',
            'concept' => 'Dari Purabaya, mau ke mana?',
            'destinations' => $destinations,
            'featuredDestinations' => array_slice($featuredDestinations, 0, 6),
            'todayDepartures' => $todayDepartures,
            'logoImage' => $logoImage,
            'logoAlt' => $logoAlt,
            'heroImage' => $heroImage,
            'heroAlt' => $heroAlt,
            'terminalImage' => $terminalImage,
            'terminalAlt' => $terminalAlt,
        ];

        return view('home/index', $data);
    }
}
