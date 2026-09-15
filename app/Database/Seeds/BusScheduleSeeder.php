<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BusScheduleSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('bus_schedules')->truncate();
        $this->db->table('bus')->truncate();
        $this->db->table('shelters')->truncate();
        $this->db->table('destinations')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        $now = date('Y-m-d H:i:s');
        $services = [
            [1, 'patas', ['Ngawi'], ['Sudiro Tungga Jaya (STJ)'], 90000, 90000],
            [2, 'patas', ['Balung', 'Kencong', 'Ambulu', 'Situbondo', 'Bondowoso', 'Banyuwangi'], ['Ladju', 'Damri'], 55000, 55000],
            [3, 'patas', ['Madura', 'Sumenep'], ['Akas Group', 'Pelita Mas', 'Mila Sejahtera', 'Pahala Kencana'], 60000, 60000],
            [4, 'patas', ['Pare', 'Wates', 'Blitar'], ['Bagong', 'Harapan Jaya'], 45000, 70000],
            [5, 'patas', ['Probolinggo', 'Jember'], ['Akas Aurora', 'Mila Sejahtera', 'Ladju', 'Akas Asri', 'Sandy Putra', 'Cipto', 'Jember Indah', 'Damri'], 100000, 155000],
            [6, 'patas', ['Kediri', 'Tulungagung', 'Trenggalek'], ['Harapan Jaya', 'Bagong'], 40000, 60000],
            [7, 'patas', ['Malang'], ['Restu', 'Kalisari', 'Tentrem', 'Hafana', 'Menggala', 'Akas Green'], 40000, 40000],
            [8, 'patas', ['Nganjuk', 'Madiun', 'Ponorogo', 'Magetan', 'Pacitan'], ['Restu', 'Kalisari', 'Sudiro Tungga Jaya (STJ)', 'Ponorogo Indah'], 70000, 130000],
            [9, 'ekonomi', ['Malang', 'Blitar'], ['Restu', 'Tentrem', 'Kalisari', 'Bagong', 'Hafana'], 20000, 20000],
            [10, 'ekonomi', ['Madura'], ['Akas', 'Damri'], 45000, 45000],
            [11, 'ekonomi', ['Madiun', 'Ponorogo', 'Pacitan'], ['Restu', 'Jaya', 'Aneka Jaya'], 40000, 90000],
            [12, 'ekonomi', ['Bondowoso', 'Jember', 'Banyuwangi'], ['Bagong', 'Akas', 'Ladju', 'Damri'], 55000, 100000],
            [13, 'ekonomi', ['Kediri', 'Tulungagung', 'Trenggalek'], ['Bagong', 'Harapan Jaya'], 30000, 60000],
            [14, 'ekonomi', ['Ambulu'], ['Bagong', 'Ladju', 'Akas', 'Sabar Indah'], 70000, 70000],
            [15, 'ekonomi', ['Bojonegoro', 'Tuban', 'Cepu'], ['Rajawali Indah', 'Dali Mas', 'Bintang Mas', 'Widji', 'Jaya Utama Indo'], 30000, 40000],
            [17, 'ekonomi', ['Purwokerto', 'Tasikmalaya', 'Bandung'], ['Sugeng Rahayu'], 160000, 160000],
            [18, 'ekonomi', ['Solo', 'Jogja'], ['Sugeng Rahayu', 'Mira'], 57000, 77000],
            [19, 'ekonomi', ['Tuban', 'Semarang', 'Cirebon'], ['Jaya Utama Indo', 'Sinar Mandiri Mulia', 'Widji'], 90000, 110000],
            [20, 'patas', ['Solo', 'Jogja', 'Magelang', 'Semarang'], ['Eka Cepat', 'Sugeng Rahayu Golden Star'], 100000, 150000],
            [21, 'patas', ['Tuban', 'Semarang'], ['Sinar Mandiri Mulia', 'Jaya Utama Indo', 'Widji'], 50000, 65000],
            [22, 'executive', ['Purwokerto', 'Cilacap'], ['Eka Cepat', 'Sugeng Rahayu'], 200000, 295000],
            [23, 'executive', ['Denpasar', 'Mataram'], ['Angkasa', 'Bali Trans', 'Sakhindra', 'M-Trans'], 450000, 450000],
            [24, 'executive', ['Bandung'], ['Eka Cepat', 'Sugeng Rahayu'], 310000, 320000],
        ];

        $destinationIds = [];
        foreach ($services as $service) {
            foreach ($service[2] as $destination) {
                if (!isset($destinationIds[$destination])) {
                    $this->db->table('destinations')->insert(['destination_name' => $destination, 'description' => 'Tujuan bus dari Terminal Purabaya.', 'created_at' => $now, 'updated_at' => $now]);
                    $destinationIds[$destination] = $this->db->insertID();
                }
            }
        }

        for ($number = 1; $number <= 24; $number++) {
            $service = array_values(array_filter($services, static fn (array $item): bool => $item[0] === $number));
            $category = $service ? $service[0][1] : 'jalur_bebas';
            $this->db->table('shelters')->insert(['shelter_number' => $number, 'category' => $category, 'created_at' => $now, 'updated_at' => $now]);
        }

        $shelterIds = [];
        foreach ($this->db->table('shelters')->get()->getResultArray() as $shelter) {
            $shelterIds[(int) $shelter['shelter_number']] = $shelter['id'];
        }

        foreach ($services as $service) {
            [$number, $category, $destinations, $operators, $fare, $fareMax] = $service;
            foreach ($destinations as $destination) {
                foreach ($operators as $operator) {
                    $this->db->table('bus')->insert([
                        'operator' => $operator,
                        'destination_id' => $destinationIds[$destination],
                        'shelter_id' => $shelterIds[$number],
                        'bus_class' => $category,
                        'departure_time' => '06:00:00',
                        'fare' => $fare,
                        'fare_max' => $fareMax,
                        'departure_area' => 'Shelter ' . $number,
                        'ticket_information' => 'Informasi tarif dan keberangkatan, bukan pemesanan tiket.',
                        'description' => 'Informasi layanan bus dari Terminal Purabaya.',
                        'quantity' => 1,
                        'capacity' => 40,
                        'status' => 'aktif',
                        'last_updated' => $now,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }

        $scheduleRules = [
            1 => ['status' => 'estimated', 'note' => 'Perkiraan keberangkatan sekitar 05.00-21.00.'],
            2 => ['status' => 'estimated', 'times' => ['10:30', '12:00', '14:40', '20:00', '22:30'], 'note' => 'Perkiraan keberangkatan.'],
            3 => ['status' => 'estimated', 'note' => 'Perkiraan keberangkatan sekitar 08.00-17.00.'],
            4 => ['status' => 'estimated', 'operatorNotes' => ['Bagong' => 'Perkiraan sekitar 07.00-17.00.', 'Harapan Jaya' => 'Perkiraan sekitar 06.40-20.50.'], 'frequency' => 'Sekitar 30 menit'],
            5 => ['status' => 'estimated', 'note' => 'Perkiraan keberangkatan sekitar 06.00-22.00.'],
            6 => ['status' => 'flexible', 'frequency' => 'Menyesuaikan ketersediaan bus', 'note' => 'Operasional 24 jam.'],
            7 => ['status' => 'estimated', 'note' => 'Perkiraan keberangkatan sekitar 03.30-21.30.'],
            8 => ['status' => 'estimated', 'note' => 'Perkiraan keberangkatan sekitar 05.00-22.00.'],
            9 => ['status' => 'estimated', 'note' => 'Perkiraan keberangkatan sekitar 03.30-21.30.'],
            10 => ['status' => 'flexible', 'frequency' => 'Interval sekitar 30-60 menit', 'note' => 'Operasional 24 jam.'],
            11 => ['status' => 'estimated', 'note' => 'Perkiraan keberangkatan sekitar 05.00-22.00.'],
            12 => ['status' => 'estimated', 'operatorTimes' => ['Ladju' => ['10:30', '14:40'], 'Damri' => ['20:00', '22:30']], 'note' => 'Jadwal operator lain merupakan perkiraan.'],
            13 => ['status' => 'flexible', 'frequency' => 'Menyesuaikan ketersediaan bus', 'note' => 'Operasional 24 jam.'],
            14 => ['status' => 'estimated', 'note' => 'Perkiraan keberangkatan sekitar 06.00-20.00.'],
            15 => ['status' => 'estimated', 'operatorNotes' => ['Dali Mas' => 'Perkiraan sekitar 06.00-21.00.', 'Jaya Utama Indo' => 'Perkiraan sekitar 07.00-14.00 dan 17.00-21.00.', 'Rajawali Indah' => 'Perkiraan pada 07.00, 12.00, 16.00.']],
            17 => ['status' => 'available', 'times' => ['07:45', '08:45', '11:15', '14:15', '16:35', '19:55']],
            18 => ['status' => 'flexible', 'frequency' => 'Sekitar 15 menit untuk layanan tertentu', 'note' => 'Operasional 24 jam.'],
            19 => ['status' => 'estimated', 'frequency' => 'Sekitar 60 menit', 'note' => 'Perkiraan keberangkatan sekitar 05.30-23.00.'],
            20 => ['status' => 'estimated', 'note' => 'Perkiraan keberangkatan sekitar 01.00-23.15.'],
            21 => ['status' => 'estimated', 'frequency' => 'Sekitar 60 menit', 'note' => 'Perkiraan keberangkatan sekitar 05.30-23.00.'],
            22 => ['status' => 'available', 'times' => ['06:00', '06:20', '07:40', '10:00', '11:30', '14:00', '14:30', '16:00', '16:45']],
            23 => ['status' => 'estimated', 'note' => 'Perkiraan keberangkatan sekitar 14.00-20.00.'],
            24 => ['status' => 'available', 'times' => ['06:10', '07:10', '07:55', '08:40', '10:10', '11:10', '12:15', '13:50', '14:40', '15:45', '17:15', '18:45', '20:15', '21:45', '23:15']],
        ];
        foreach ($this->db->table('bus')->get()->getResultArray() as $bus) {
            $rule = $scheduleRules[(int) $this->db->table('shelters')->where('id', $bus['shelter_id'])->get()->getRow('shelter_number')] ?? ['status' => 'flexible', 'note' => 'Informasi keberangkatan menyesuaikan operasional terminal.'];
            $times = $rule['operatorTimes'][$bus['operator']] ?? ($rule['times'] ?? [null]);
            $note = $rule['operatorNotes'][$bus['operator']] ?? ($rule['note'] ?? null);
            foreach ($times as $time) {
                $this->db->table('bus_schedules')->insert([
                    'bus_id' => $bus['id'], 'departure_time' => $time, 'schedule_status' => $rule['status'],
                    'frequency' => $rule['frequency'] ?? null, 'note' => $note, 'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }
    }
}