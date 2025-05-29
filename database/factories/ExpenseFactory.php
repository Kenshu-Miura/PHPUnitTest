<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'description' => $this->faker->sentence(),
            'category' => $this->faker->randomElement(['食費', '交通費', '日用品', '光熱費', 'その他']),
            'expense_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
} 