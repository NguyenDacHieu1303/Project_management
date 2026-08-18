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
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('topic_id');
            $table->string('title'); // Ví dụ: "Đề cương", "Giữa kỳ", "Cuối kỳ"
            $table->dateTime('deadline'); // Hạn chót nộp
            $table->tinyInteger('order_number'); // Thứ tự: 1, 2, 3...
            $table->timestamps();

            // Foreign Key constraint
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milestones');
    }
};
