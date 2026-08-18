<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milestone_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('milestone_id');
            $table->unsignedBigInteger('student_id');
            $table->string('file_path'); // Đường dẫn file nộp
            $table->text('note')->nullable(); // Ghi chú từ sinh viên
            $table->dateTime('submitted_at'); // Ngày nộp
            $table->timestamps();

            // Foreign Key constraints
            $table->foreign('milestone_id')->references('id')->on('milestones')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            
            // Constraint: 1 sinh viên chỉ nộp 1 file cho 1 milestone
            $table->unique(['milestone_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milestone_submissions');
    }
};
