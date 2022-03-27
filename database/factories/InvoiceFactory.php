<?php

namespace Database\Factories;

use App\Models\BalanceHistory;
use App\Repositories\InvoiceRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $id = $this->faker->unique()->regexify('[a-z0-9]{24}');
        $status = $this->faker->randomElement(['PAID', 'PENDING']);
        $paymentMethods = $this->faker->randomElement([
            'BANK_TRANSFER', 'RETAIL_OUTLET', 'EWALLET',
        ]);
        $paymentMethod = $status == 'PAID' ? $paymentMethods : null;
        switch ($paymentMethod) {
            case 'BANK_TRANSFER':
                $paymentChannel = $this->faker->randomElement(InvoiceRepository::$bankPaymentChannels);
                break;

            case 'RETAIL_OUTLET':
                $paymentChannel = $this->faker->randomElement(InvoiceRepository::$retailPaymentChannels);
                break;

            case 'EWALLET':
                $paymentChannel = $this->faker->randomElement(InvoiceRepository::$ewalletPaymentChannels);
                break;

            default:
                $paymentChannel = null;
                break;
        }
        $price = [180000, 240000, 350000, 410000, 480000, 510000];
        $amount = $this->faker->randomElement($price);
        return [
            'ref_id' => InvoiceRepository::generateRefId(),
            'invoice_id' => $id,
            'invoice_url' => "https://checkout-staging.xendit.co/web/$id",
            'status' => $status,
            'payment_method' => $paymentChannel,
            'amount' => $amount,
            'paid_at' => $status == 'PAID' ? $this->faker->dateTimeBetween('-5 days', '-4 days') : null,
            'expiry_date' => $this->faker->dateTimeBetween('-3 day'),
            'balance_history_id' => BalanceHistory::factory()->create([
                'amount' => $amount,
                'type' => 'TOPUP',
            ])->id,
        ];
    }
}
