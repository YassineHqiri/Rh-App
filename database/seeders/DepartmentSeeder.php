<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'Human Resources', 'description' => 'Manages recruitment, employee relations, and HR operations.'],
            ['name' => 'Finance', 'description' => 'Handles accounting, budgeting, and financial reporting.'],
            ['name' => 'Information Technology', 'description' => 'Manages IT infrastructure, development, and support.'],
            ['name' => 'Marketing', 'description' => 'Drives brand strategy, campaigns, and market research.'],
            ['name' => 'Operations', 'description' => 'Oversees day-to-day business operations and logistics.'],
            ['name' => 'Sales', 'description' => 'Manages client relationships and revenue generation.'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['name' => $dept['name']], $dept);
        }
    }
}
