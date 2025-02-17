<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_kirim');
            $table->date('tenggat_waktu');
            $table->text('lampiran')->nullable();
            $table->string('kategori');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['baru', 'sedang dikerjakan', 'selesai', 'tertunda']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}