<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notifications_settings')->insert([
            [
                'name' => 'student_attendance',
                'mail' => 0,
                'sms' => 0,
                'whatsapp' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'teacher_attendance',
                'mail' => 0,
                'sms' => 0,
                'whatsapp' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'guardian_attendance',
                'mail' => 0,
                'sms' => 0,
                'whatsapp' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'employee_attendance',
                'mail' => 0,
                'sms' => 0,
                'whatsapp' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'send_msg',
                'mail' => 0,
                'sms' => 0,
                'whatsapp' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
