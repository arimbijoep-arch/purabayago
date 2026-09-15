<?php

namespace App\Controllers;

use App\Models\BusModel;
use App\Models\DestinationModel;

class Search extends BaseController
{
    public function index()
    {
        $destinationModel = new DestinationModel();
        $destinations = $this->sortDestinations($destinationModel->findAll());
        $busModel = new BusModel();
        $filters = $this->request->getGet();
        unset($filters['shelter_id']);
        if (array_filter($filters, static fn ($value): bool => $value !== null && $value !== '')) {
            return $this->results($filters, $destinations, $busModel);
        }
        return view('search/index', ['destinations' => $destinations, 'shelters' => $busModel->getShelters()]);
    }

    public function byDestination()
    {
        $destinationId = $this->request->getGet('destination_id');
        $busClass = $this->request->getGet('category');
        $destinationModel = new DestinationModel();
        $busModel = new BusModel();

        if (empty($destinationId)) {
            return redirect()->to('/search')->with('error', 'Pilih tujuan terlebih dahulu.');
        }

        $destination = $destinationModel->find($destinationId);
        $filters = ['destination_id' => $destinationId, 'category' => $busClass];
        return view('search/results', ['destination' => $destination, 'busClass' => $busClass, 'buses' => $busModel->groupServices($busModel->getServiceRows($filters)), 'filters' => $filters, 'destinations' => $this->sortDestinations($destinationModel->findAll()), 'shelters' => $busModel->getShelters()]);
    }

    public function byCategory()
    {
        $destinationId = $this->request->getGet('destination_id');
        $busClass = $this->request->getGet('category');

        if (empty($destinationId) || empty($busClass)) {
            return redirect()->to('/search')->with('error', 'Tujuan dan kategori bus harus dipilih.');
        }

        $destinationModel = new DestinationModel();
        $busModel = new BusModel();

        $destination = $destinationModel->find($destinationId);
        $buses = $busModel->groupServices($busModel->getServiceRows([
            'destination_id' => $destinationId,
            'category' => $busClass,
        ]));

        return view('search/results', [
            'destination' => $destination,
            'busClass' => $busClass,
            'buses' => $buses,
            'filters' => ['destination_id' => $destinationId, 'category' => $busClass],
            'destinations' => $this->sortDestinations($destinationModel->findAll()),
            'shelters' => $busModel->getShelters(),
        ]);
    }

    private function results(array $filters, array $destinations, BusModel $busModel)
    {
        $rows = $busModel->getServiceRows($filters);
        $query = strtolower(trim((string) ($filters['q'] ?? '')));
        $normalizedQuery = str_replace(['eksekutif', 'patas', 'ekonomi'], ['executive', 'patas', 'ekonomi'], $query);
        $fare = (float) ($filters['fare'] ?? 0);
        if (!$fare && preg_match('/\d[\d.]*/', $query, $fareMatch)) {
            $fare = (float) str_replace('.', '', $fareMatch[0]);
        }
        $time = str_replace('.', ':', trim((string) ($filters['time'] ?? '')));
        $rows = array_filter($rows, static function (array $row) use ($query, $normalizedQuery, $fare, $time): bool {
            $matchesQuery = !$query || str_contains(strtolower($row['destination_name'] . ' ' . $row['operator'] . ' ' . ($row['bus_class'] ?? '')), $normalizedQuery) || $fare > 0;
            $matchesFare = !$fare || ((float) $row['fare'] <= $fare && (float) ($row['fare_max'] ?? $row['fare']) >= $fare);
            $matchesTime = !$time || array_reduce($row['schedules'], static fn (bool $match, array $schedule): bool => $match || str_starts_with((string) $schedule['departure_time'], $time), false);
            return $matchesQuery && $matchesFare && $matchesTime;
        });
        $groups = $busModel->groupServices(array_values($rows));
        usort($groups, static function (array $first, array $second) use ($filters): int {
            return match ($filters['sort'] ?? 'shelter') {
                'latest' => strcmp((string) ($second['schedules'][0]['departure_time'] ?? ''), (string) ($first['schedules'][0]['departure_time'] ?? '')),
                'fare_high' => (float) $second['fare_max'] <=> (float) $first['fare_max'],
                'fare_low' => (float) $first['fare_min'] <=> (float) $second['fare_min'],
                'morning' => strcmp((string) ($first['schedules'][0]['departure_time'] ?? '99:99'), (string) ($second['schedules'][0]['departure_time'] ?? '99:99')),
                default => [$first['destination_name'] ?? '', (int) ($first['shelter_number'] ?? 99)] <=> [$second['destination_name'] ?? '', (int) ($second['shelter_number'] ?? 99)],
            };
        });
        return view('search/results', ['destination' => null, 'busClass' => $filters['category'] ?? null, 'buses' => $groups, 'filters' => $filters, 'destinations' => $this->sortDestinations($destinations), 'shelters' => $busModel->getShelters()]);
    }

    private function sortDestinations(array $destinations): array
    {
        usort($destinations, static fn (array $first, array $second): int => strcasecmp((string) $first['destination_name'], (string) $second['destination_name']));
        return $destinations;
    }
}
