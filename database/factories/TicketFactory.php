<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status'=> fake()->randomElements(['open', 'close']),
            'priority'=> fake()->randomElements(['low', 'medium']),
            'file'=>fake()->imageUrl(640, 480),
            'user_id'=>User::factory()->create(['role'=>'user'])->id
        ];
    }
}
