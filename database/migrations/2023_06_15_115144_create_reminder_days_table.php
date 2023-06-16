<?php

use App\Models\ReminderDay;
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
        Schema::create('reminder_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reminder_id')->constrained()->cascadeOnDelete();
            $table->enum('day', [
                ReminderDay::MONDAY,
                ReminderDay::TUESDAY,
                ReminderDay::WEDNESDAY,
                ReminderDay::THURSDAY,
                ReminderDay::FRIDAY,
                ReminderDay::SATURDAY,
                ReminderDay::SUNDAY
            ]);
            $table->unique(['reminder_id', 'day']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reminder_days');
    }
};
