<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointments = [];
        for ($i = 0; $i < 50; $i++) {
            $appointments[] = [
                'title' => 'Appointment ' . $i,
                'creator_id' => rand(1, 3),
                'receiver_id' => rand(1, 3),
                'start' => now()->addDays(rand(1, 30))->hours(rand(8, 16))->minutes(rand(0, 59))->seconds(rand(0, 59)),
                'end' => now()->addDays(rand(1, 30))->hours(rand(8, 16))->minutes(rand(0, 59))->seconds(rand(0, 59)),
                // 'start' => now()->subDays(rand(1, 30))->hour(rand(8, 16))->minute(rand(0, 59))->second(rand(0, 59)),
                // 'end' => now()->subDays(rand(1, 30))->hour(rand(8, 16))->minute(rand(0, 59))->second(rand(0, 59)),

            ];
        }

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }
    }
}
