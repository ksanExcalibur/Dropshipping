<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'vendor_id' => \App\Models\User::factory(),
            'status' => 'pending',
            'total' => $this->faker->randomFloat(2, 10, 1000),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'pincode' => $this->faker->postcode,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}