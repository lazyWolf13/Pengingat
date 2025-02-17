<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->date('tanggal');
            $table->timestamp('waktu_check_in')->nullable();
            $table->timestamp('waktu_check_out')->nullable();
            $table->string('lokasi_absen')->nullable();
            $table->enum('ketepatan_waktu', ['tepat waktu', 'terlambat', 'lembur'])->nullable();
            $table->time('durasi_lembur')->nullable();
            $table->enum('status', ['hadir', 'izin', 'cuti', 'alpa']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_records');
    }
}