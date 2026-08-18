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
    Schema::table('topics', function (Blueprint $table) {
        // Thêm cột lecturer_id vào sau cột id (hoặc bất kỳ vị trí nào)
        $table->foreignId('lecturer_id')->nullable()->constrained('lecturers')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('topics', function (Blueprint $table) {
        $table->dropForeign(['lecturer_id']);
        $table->dropColumn('lecturer_id');
    });
}
};
