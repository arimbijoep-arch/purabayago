<?php

namespace App\Controllers;

use App\Models\BusModel;
use App\Models\DestinationModel;

class Destination extends BaseController
{
    public function index()
    {
        $destinationModel = new DestinationModel();
        $busModel = new BusModel();
        $destinations = $destinationModel->findAll();

        foreach ($destinations as &$destination) {
            $summary = $busModel
                ->select("COUNT(DISTINCT CONCAT(shelter_id, '-', bus_class)) AS service_count, MIN(fare) AS min_fare")
                ->where('destination_id', $destination['id'])
                ->first();
            $categories = $busModel
                ->select('bus_class')
                ->distinct()
                ->where('destination_id', $destination['id'])
                ->orderBy('bus_class', 'ASC')
                ->findAll();

            $destination['service_count'] = (int) ($summary['service_count'] ?? 0);
            $destination['bus_count'] = $destination['service_count'];
            $destination['min_fare'] = $summary['min_fare'] ?? null;
            $destination['categories'] = array_column($categories, 'bus_class');
        }
        unset($destination);

        $totalBuses = $busModel->countAllResults();
        $popularDestinations = $destinations;
        usort($popularDestinations, static fn (array $first, array $second): int => $second['bus_count'] <=> $first['bus_count']);

        return view('destinations/index', [
            'destinations' => $destinations,
            'popularDestinations' => array_slice($popularDestinations, 0, 3),
            'totalBuses' => $totalBuses,
        ]);
    }
}