<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Milestone;
use App\Models\Student;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MilestoneSubmission>
 */
class MilestoneSubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'milestone_id' => Milestone::factory(),
            'student_id' => Student::factory(),
            'file_path' => 'submissions/' . $this->faker->slug() . '.pdf',
            'note' => $this->faker->realText(100),
            'submitted_at' => Carbon::now()->subDays($this->faker->numberBetween(1, 30)),
        ];
    }
}
