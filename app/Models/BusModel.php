<?php

namespace App\Models;

use CodeIgniter\Model;

class BusModel extends Model
{
    protected $table            = 'bus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'operator',
        'destination_id',
        'shelter_id',
        'photo',
        'photo_alt',
        'photo_caption',
        'bus_class',
        'departure_time',
        'fare',
        'fare_max',
        'departure_area',
        'ticket_information',
        'description',
        'quantity',
        'capacity',
        'status',
        'last_updated',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getByDestinationAndClass(int $destinationId, string $busClass): array
    {
        return $this->where('destination_id', $destinationId)
            ->where('bus_class', $busClass)
            ->orderBy('departure_time', 'ASC')
            ->findAll();
    }

    public function getBusDetail(int $id): ?array
    {
        $bus = $this->select('bus.*, destinations.destination_name, shelters.shelter_number')
            ->join('destinations', 'destinations.id = bus.destination_id', 'left')
            ->join('shelters', 'shelters.id = bus.shelter_id', 'left')
            ->where('bus.id', $id)
            ->first();

        if (!$bus) {
            return null;
        }

        $relatedBuses = $this->select('bus.*, destinations.destination_name, shelters.shelter_number')
            ->join('destinations', 'destinations.id = bus.destination_id', 'left')
            ->join('shelters', 'shelters.id = bus.shelter_id', 'left')
            ->where('destination_id', $bus['destination_id'])
            ->where('shelter_id', $bus['shelter_id'])
            ->where('bus_class', $bus['bus_class'])
            ->orderBy('operator', 'ASC')
            ->findAll();

        $relatedIds = array_column($relatedBuses, 'id');
        $scheduleRows = $relatedIds ? $this->db->table('bus_schedules')
            ->whereIn('bus_id', $relatedIds)
            ->orderBy('departure_time', 'ASC')
            ->get()->getResultArray() : [];
        $bus['operators'] = [];
        $bus['operator_services'] = [];
        $bus['schedules'] = [];
        $bus['fare_min'] = (float) $bus['fare'];
        $bus['fare_max'] = (float) ($bus['fare_max'] ?? $bus['fare']);

        foreach ($relatedBuses as $relatedBus) {
            $bus['operators'][$relatedBus['operator']] = ['operator' => $relatedBus['operator']];
            $bus['operator_services'][] = [
                'operator' => $relatedBus['operator'],
                'photo' => $relatedBus['photo'],
                'photo_alt' => $relatedBus['photo_alt'],
                'photo_caption' => $relatedBus['photo_caption'],
            ];
            $bus['fare_min'] = min($bus['fare_min'], (float) $relatedBus['fare']);
            $bus['fare_max'] = max($bus['fare_max'], (float) ($relatedBus['fare_max'] ?? $relatedBus['fare']));
            if (empty($bus['photo']) && !empty($relatedBus['photo'])) {
                $bus['photo'] = $relatedBus['photo'];
                $bus['photo_alt'] = $relatedBus['photo_alt'];
                $bus['photo_caption'] = $relatedBus['photo_caption'];
            }
        }

        foreach ($scheduleRows as $schedule) {
            $scheduleKey = ($schedule['departure_time'] ?? '') . ':' . ($schedule['schedule_status'] ?? '') . ':' . ($schedule['frequency'] ?? '') . ':' . ($schedule['note'] ?? '');
            $bus['schedules'][$scheduleKey] = $schedule;
        }
        $bus['operators'] = array_values($bus['operators']);
        $bus['schedules'] = array_values($bus['schedules']);

        return $bus;
    }

    public function getShelters(): array
    {
        return $this->db->table('shelters')->orderBy('shelter_number', 'ASC')->get()->getResultArray();
    }

    public function getServiceRows(array $filters = []): array
    {
        $builder = $this->select('bus.*, destinations.destination_name, shelters.shelter_number')
            ->join('destinations', 'destinations.id = bus.destination_id', 'left')
            ->join('shelters', 'shelters.id = bus.shelter_id', 'left')
            ->orderBy('destinations.destination_name', 'ASC')
            ->orderBy('shelters.shelter_number', 'ASC')
            ->orderBy('bus.bus_class', 'ASC')
            ->orderBy('bus.operator', 'ASC');

        if (!empty($filters['destination_id'])) {
            $builder->where('bus.destination_id', (int) $filters['destination_id']);
        }
        if (!empty($filters['category']) && in_array($filters['category'], ['ekonomi', 'patas', 'executive'], true)) {
            $builder->where('bus.bus_class', $filters['category']);
        }
        if (!empty($filters['shelter_id'])) {
            $builder->where('bus.shelter_id', (int) $filters['shelter_id']);
        }

        $rows = $builder->findAll();
        if (!$rows) {
            return [];
        }

        $scheduleRows = $this->db->table('bus_schedules')
            ->whereIn('bus_id', array_column($rows, 'id'))
            ->orderBy('departure_time', 'ASC')
            ->get()->getResultArray();
        $schedules = [];
        foreach ($scheduleRows as $schedule) {
            $schedules[$schedule['bus_id']][] = $schedule;
        }
        foreach ($rows as &$row) {
            $row['schedules'] = $schedules[$row['id']] ?? [];
        }
        unset($row);

        return $rows;
    }

    public function groupServices(array $rows): array
    {
        $groups = [];
        foreach ($rows as $row) {
            $key = implode(':', [$row['destination_id'], $row['shelter_id'], $row['bus_class']]);
            if (!isset($groups[$key])) {
                $groups[$key] = $row;
                $groups[$key]['operators'] = [];
                $groups[$key]['operator_services'] = [];
                $groups[$key]['fare_min'] = (float) $row['fare'];
                $groups[$key]['fare_max'] = $row['fare_max'] !== null ? (float) $row['fare_max'] : (float) $row['fare'];
                $groups[$key]['schedules'] = [];
            }
            $groups[$key]['operators'][] = $row['operator'];
            $groups[$key]['operator_services'][] = [
                'operator' => $row['operator'],
                'photo' => $row['photo'] ?? null,
                'photo_alt' => $row['photo_alt'] ?? null,
                'photo_caption' => $row['photo_caption'] ?? null,
            ];
            if (empty($groups[$key]['photo']) && !empty($row['photo'])) {
                $groups[$key]['photo'] = $row['photo'];
                $groups[$key]['photo_alt'] = $row['photo_alt'] ?? null;
                $groups[$key]['photo_caption'] = $row['photo_caption'] ?? null;
            }
            foreach ($row['schedules'] as $schedule) {
                $scheduleKey = ($schedule['departure_time'] ?? '') . ':' . $schedule['schedule_status'] . ':' . ($schedule['frequency'] ?? '');
                $groups[$key]['schedules'][$scheduleKey] = $schedule;
            }
            $groups[$key]['fare_min'] = min($groups[$key]['fare_min'], (float) $row['fare']);
            $groups[$key]['fare_max'] = max($groups[$key]['fare_max'], (float) ($row['fare_max'] ?? $row['fare']));
        }

        foreach ($groups as &$group) {
            $group['schedules'] = array_values($group['schedules']);
        }
        unset($group);

        return array_values($groups);
    }

    public function syncSchedules(int $busId, ?string $times, string $status = 'estimated', ?string $frequency = null, ?string $note = null): void
    {
        $this->db->table('bus_schedules')->where('bus_id', $busId)->delete();
        $values = array_filter(array_map('trim', explode(',', (string) $times)));
        if (!$values) {
            $values = [null];
        }
        $now = date('Y-m-d H:i:s');
        foreach ($values as $value) {
            $time = $value === null ? null : str_replace('.', ':', $value) . (strlen($value) === 5 ? ':00' : '');
            $this->db->table('bus_schedules')->insert([
                'bus_id' => $busId,
                'departure_time' => $time,
                'schedule_status' => in_array($status, ['available', 'estimated', 'flexible'], true) ? $status : 'estimated',
                'frequency' => $frequency ?: null,
                'note' => $note ?: null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function getScheduleInput(int $busId): array
    {
        return $this->db->table('bus_schedules')->where('bus_id', $busId)->orderBy('departure_time', 'ASC')->get()->getResultArray();
    }
}
