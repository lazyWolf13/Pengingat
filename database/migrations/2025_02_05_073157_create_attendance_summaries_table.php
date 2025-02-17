<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceSummariesTable extends Migration
{
    public function up()
    {
        Schema::create('attendance_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('total_hadir');
            $table->integer('total_terlambat');
            $table->time('total_lembur')->nullable();
            $table->integer('total_izin');
            $table->integer('total_cuti');
            $table->foreignId('admin_id')->nullable()->constrained('admin_users')->onDelete('set null');
            $table->timestamp('managed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_summaries');
    }
}