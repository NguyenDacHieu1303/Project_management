<?php

namespace Tests\Feature;

use App\Models\Lecturer;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationAndAssignmentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_student_registration_creates_student_profile()
    {
        $response = $this->post('/register', [
            'name' => 'Sinh Viên Test',
            'email' => 'sinhvien.test@tlu.edu.vn',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertRedirect('/');

        $user = User::where('email', 'sinhvien.test@tlu.edu.vn')->firstOrFail();
        $this->assertSame('student', $user->role);
        $this->assertNotNull($user->student);
    }

    public function test_assigning_lecturer_links_topic_to_lecturer()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $lecturerUser = User::factory()->create(['role' => 'lecturer']);
        $lecturer = Lecturer::create([
            'user_id' => $lecturerUser->id,
            'lecturer_code' => 'GV001',
            'specialization' => 'Công nghệ phần mềm',
            'quota' => 5,
        ]);

        $topic = Topic::create([
            'title' => 'Đề tài kiểm thử phân công',
            'description' => 'Mô tả kiểm thử',
            'major' => 'Công nghệ phần mềm',
            'semester' => 'Học kỳ 1 - 2026',
            'status' => 'Open',
        ]);

        $response = $this->actingAs($admin)->post('/assignments', [
            'topic_id' => $topic->id,
            'lecturer_id' => $lecturer->id,
            'role' => 'Hướng dẫn chính',
        ]);

        $response->assertRedirect(route('assignments.index'));
        $this->assertDatabaseHas('topic_assignments', [
            'topic_id' => $topic->id,
            'lecturer_id' => $lecturer->id,
        ]);
        $this->assertSame($lecturer->id, $topic->fresh()->lecturer_id);
    }
}
