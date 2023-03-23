<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => 1000001,
            'name' => 'INDONESIA',
            'type' => 'COUNTRY',
            'latitude' => '-6.21462',
            'longitude' => '106.84513',
            'parentId' => null
        ];
    }
}
