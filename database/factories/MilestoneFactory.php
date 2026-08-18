<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topic;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Milestone>
 */
class MilestoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'topic_id' => Topic::factory(),
            'title' => $this->faker->randomElement(['Đề cương', 'Giữa kỳ', 'Cuối kỳ']),
            'deadline' => Carbon::now()->addDays($this->faker->numberBetween(7, 60)),
            'order_number' => $this->faker->numberBetween(1, 5),
        ];
    }
}
