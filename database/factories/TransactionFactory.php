<?php

namespace Database\Factories;

use App\Helpers\Digiflazz;
use App\Models\BalanceHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $amount = $this->faker->randomNumber($this->faker->numberBetween(5, 8), true);
        $front = ['xl', 'ts', 'th', 'sf'];
        return [
            'ref_id' => Digiflazz::generateRefId(),
            'product' => $this->faker->word(),
            'customer_no' => $this->faker->numberBetween(),
            'sku_code' => $this->faker->randomElement($front) . $this->faker->randomNumber(2, true),
            'serial_number' => $this->faker->numberBetween(),
            'status' => $this->faker->word(),
            'amount' => $amount,
            'response_code' => $this->faker->randomNumber(2),
            'balance_history_id' => BalanceHistory::factory()->create([
                'amount' => $amount,
                'type' => 'BUY',
            ])->id,
        ];
    }
}
