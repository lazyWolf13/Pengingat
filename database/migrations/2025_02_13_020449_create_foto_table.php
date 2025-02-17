<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotoTable extends Migration
{
    public function up()
    {
        Schema::create('foto', function (Blueprint $table) {
            $table->id();
            $table->string('file'); // Path file gambar
            $table->string('judul')->nullable(); // Judul atau deskripsi gambar
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('foto');
    }
}
