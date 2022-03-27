<?php

namespace Database\Factories;

use App\Models\Balance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BalanceHistory>
 */
class BalanceHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomNumber($this->faker->numberBetween(5, 8), true),
            'type' => $this->faker->randomElement(['TOPUP', 'BUY']),
            'balance_id' => Balance::inRandomOrder()->first()->id,
        ];
    }
}
