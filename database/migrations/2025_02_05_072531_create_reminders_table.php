<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindersTable extends Migration
{
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->enum('reminder_type', ['otomatis', 'berulang']);
            $table->date('reminder_date');
            $table->text('reminder_message');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reminders');
    }
}