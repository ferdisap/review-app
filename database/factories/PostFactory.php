<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
          'isDraft' => rand(0,1),
          'title' => fake()->word(),
          'token' => Str::ulid(),
          'category_id' => 1,
          'author_id' => 1
        ];
    }
}
