<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pitch_id')->nullable()->constrained('pitches')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('schedule_id')->nullable()->constrained('schedules')->onDelete('cascade');
            $table->foreignId('slot_id')->nullable()->constrained('slots')->onDelete('cascade');
            $table->decimal('subtotal', 13, 3)->comment('price of the pitch')->default(0.000);
            $table->decimal('added_tax', 13, 3)->default(0.000);
            $table->decimal('total', 13, 3)->default(0.000);
            $table->timestamp('reservation_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
