<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendance_summaries', function (Blueprint $table) {
            $table->foreignId('attendance_record_id')->nullable()->constrained('attendance_records')->onDelete('set null');
            $table->integer('total_hadir')->default(0);
            $table->integer('total_terlambat')->default(0);
            $table->integer('total_lembur')->default(0);
            $table->integer('total_izin')->default(0);
            $table->integer('total_cuti')->default(0);
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('managed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_summaries', function (Blueprint $table) {
            $table->dropForeign(['attendance_record_id']);
            $table->dropForeign(['admin_id']);
            $table->dropColumn([
                'attendance_record_id',
                'total_hadir',
                'total_terlambat',
                'total_lembur',
                'total_izin',
                'total_cuti',
                'admin_id',
                'managed_at'
            ]);
        });
    }
};
