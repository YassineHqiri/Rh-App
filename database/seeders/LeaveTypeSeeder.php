<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'Annual Leave', 'default_days_per_year' => 21],
            ['name' => 'Sick Leave', 'default_days_per_year' => 10],
            ['name' => 'Personal Leave', 'default_days_per_year' => 5],
            ['name' => 'Unpaid Leave', 'default_days_per_year' => 0],
            ['name' => 'Maternity Leave', 'default_days_per_year' => 90],
            ['name' => 'Paternity Leave', 'default_days_per_year' => 5],
        ];

        foreach ($types as $type) {
            LeaveType::firstOrCreate(['name' => $type['name']], $type);
        }
    }
}
