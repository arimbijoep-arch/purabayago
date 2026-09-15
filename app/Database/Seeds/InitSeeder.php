<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitSeeder extends Seeder
{
    public function run()
    {
        $tables = ['activity_logs', 'bus', 'destinations', 'settings', 'users'];

        foreach ($tables as $table) {
            if ($this->db->tableExists($table)) {
                $this->db->query('SET foreign_key_checks = 0');
                $this->db->query('TRUNCATE TABLE ' . $table);
                $this->db->query('SET foreign_key_checks = 1');
            }
        }

        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);

        $this->db->table('users')->insert([
            'username' => 'admin',
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@purabayago.test',
            'password' => $adminPassword,
            'foto_profil' => null,
            'role' => 'admin',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $destinations = [
            'Malang',
            'Kediri',
            'Jember',
            'Banyuwangi',
            'Madiun',
            'Yogyakarta',
            'Jakarta',
        ];

        foreach ($destinations as $destinationName) {
            $this->db->table('destinations')->insert([
                'destination_name' => $destinationName,
                'description' => 'Tujuan prototype untuk kebutuhan demo dan informasi bus dari Terminal Purabaya.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $destinationRows = $this->db->table('destinations')->get()->getResultArray();

        $busData = [
            ['operator' => 'Pahala Kencana', 'destination' => 'Malang', 'bus_class' => 'ekonomi', 'departure_time' => '06:00:00', 'fare' => 250000, 'departure_area' => 'Area Keberangkatan A', 'ticket_information' => 'Pembelian tiket melalui loket/operator.', 'description' => 'Bus ekonomi jurusan Malang.', 'last_updated' => '2026-09-01 08:00:00'],
            ['operator' => 'Muda Jaya', 'destination' => 'Malang', 'bus_class' => 'patas', 'departure_time' => '07:00:00', 'fare' => 300000, 'departure_area' => 'Area Keberangkatan B', 'ticket_information' => 'Tiket tersedia di loket terminal dan agen.', 'description' => 'Bus patas dengan jadwal pagi.', 'last_updated' => '2026-09-01 08:30:00'],
            ['operator' => 'Harapan Baru', 'destination' => 'Kediri', 'bus_class' => 'ekonomi', 'departure_time' => '08:30:00', 'fare' => 220000, 'departure_area' => 'Area Keberangkatan C', 'ticket_information' => 'Informasi tiket berdasarkan loket operator.', 'description' => 'Rute Kediri dengan tarif bersahabat.', 'last_updated' => '2026-09-01 09:00:00'],
            ['operator' => 'Sumber Rejeki', 'destination' => 'Jember', 'bus_class' => 'executive', 'departure_time' => '09:15:00', 'fare' => 450000, 'departure_area' => 'Area Keberangkatan D', 'ticket_information' => 'Pembelian tiket melalui operator resmi.', 'description' => 'Bus executive dengan kenyamanan lebih baik.', 'last_updated' => '2026-09-01 09:30:00'],
            ['operator' => 'Bintang Timur', 'destination' => 'Banyuwangi', 'bus_class' => 'patas', 'departure_time' => '11:00:00', 'fare' => 320000, 'departure_area' => 'Area Keberangkatan E', 'ticket_information' => 'Tiket melalui loket dan agen.', 'description' => 'Bus patas menuju Banyuwangi.', 'last_updated' => '2026-09-01 10:00:00'],
            ['operator' => 'Nusantara', 'destination' => 'Madiun', 'bus_class' => 'ekonomi', 'departure_time' => '13:00:00', 'fare' => 210000, 'departure_area' => 'Area Keberangkatan A', 'ticket_information' => 'Tiket dapat dicek di loket terminal.', 'description' => 'Bus ekonomi untuk perjalanan siang hari.', 'last_updated' => '2026-09-01 10:30:00'],
            ['operator' => 'Sari Jaya', 'destination' => 'Yogyakarta', 'bus_class' => 'executive', 'departure_time' => '16:30:00', 'fare' => 500000, 'departure_area' => 'Area Keberangkatan B', 'ticket_information' => 'Tiket melalui operator resmi.', 'description' => 'Bus executive menuju Yogyakarta.', 'last_updated' => '2026-09-01 11:00:00'],
            ['operator' => 'Karya Mandiri', 'destination' => 'Jakarta', 'bus_class' => 'patas', 'departure_time' => '18:15:00', 'fare' => 360000, 'departure_area' => 'Area Keberangkatan F', 'ticket_information' => 'Informasi tiket dibuka di loket utama.', 'description' => 'Bus patas malam menuju Jakarta.', 'last_updated' => '2026-09-01 11:30:00'],
        ];

        foreach ($busData as $item) {
            $destinationId = null;
            foreach ($destinationRows as $destinationRow) {
                if ($destinationRow['destination_name'] === $item['destination']) {
                    $destinationId = $destinationRow['id'];
                    break;
                }
            }

            if ($destinationId === null) {
                continue;
            }

            $this->db->table('bus')->insert([
                'operator' => $item['operator'],
                'destination_id' => $destinationId,
                'bus_class' => $item['bus_class'],
                'departure_time' => $item['departure_time'],
                'fare' => $item['fare'],
                'departure_area' => $item['departure_area'],
                'ticket_information' => $item['ticket_information'],
                'description' => $item['description'],
                'quantity' => 2,
                'capacity' => 40,
                'status' => 'aktif',
                'last_updated' => $item['last_updated'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $settings = [
            [
                'setting_key' => 'app_name',
                'setting_value' => 'PURABAYA GO',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'app_tagline',
                'setting_value' => 'Temukan Busmu, Mulai Perjalananmu.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'prototype_notice',
                'setting_value' => 'DATA PROTOTYPE — bukan data real-time.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($settings as $setting) {
            $this->db->table('settings')->insert($setting);
        }

        $this->call('BusScheduleSeeder');
    }
}
