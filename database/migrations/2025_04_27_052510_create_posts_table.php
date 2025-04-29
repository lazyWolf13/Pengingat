<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->unsignedBigInteger('kategori_id');
            $table->text('isi');
            $table->unsignedBigInteger('admin_users_id');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategori')
                  ->onDelete('cascade');

            $table->foreign('admin_users_id')
                  ->references('id')
                  ->on('admin_users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}; 