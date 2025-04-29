<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gallery_id');
            $table->string('file');
            $table->string('judul');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('gallery_id')
                  ->references('id')
                  ->on('gallery')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('image');
    }
}; 