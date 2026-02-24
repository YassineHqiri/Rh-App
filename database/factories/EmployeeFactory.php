<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition()
    {
        $positions = [
            'Software Engineer', 'Senior Developer', 'Project Manager',
            'QA Analyst', 'DevOps Engineer', 'UI/UX Designer',
            'Data Analyst', 'System Administrator', 'Technical Lead',
            'Business Analyst', 'Product Manager', 'Scrum Master',
            'Database Administrator', 'Security Analyst', 'Network Engineer',
        ];

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'position' => $this->faker->randomElement($positions),
            'salary' => $this->faker->randomFloat(2, 35000, 150000),
            'hire_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'inactive']),
        ];
    }

    public function active()
    {
        return $this->state(fn () => ['status' => 'active']);
    }

    public function inactive()
    {
        return $this->state(fn () => ['status' => 'inactive']);
    }
}
