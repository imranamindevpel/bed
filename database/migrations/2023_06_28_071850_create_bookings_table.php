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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Assuming tenant_id is an integer
            $table->decimal('price', 10, 2)->default(0); // Assuming price is a decimal with 10 total digits and 2 decimal places
            $table->enum('status', ['advance_booking', 'active', 'deactivate']); // Use an enum for limited options
            $table->enum('type', ['paid', 'partial_paid']); // Use an enum for limited options
            $table->date('check_in_date')->default('2023-10-14 18:43:13'); // Assuming check_in_date is a date
            $table->date('check_out_date')->default('2023-10-14 18:43:13'); // Assuming check_out_date is a date
            $table->unsignedBigInteger('bed_id')->default(0); // Assuming bed is related to another table, use the appropriate foreign key
            $table->enum('booking_type', ['custom_days', 'daily', 'weekly', 'monthly']); // Use an enum for limited options
            $table->decimal('rent', 10, 2)->default(0); // Assuming rent is a decimal with 10 total digits and 2 decimal places
            $table->string('mess')->default(0); // You can specify the appropriate length for 'mess' if it's a string
            $table->string('mess_disc')->default(0); // You can specify the appropriate length for 'mess' if it's a string
            $table->string('mess_status')->default(0); // You can specify the appropriate length for 'mess' if it's a string
            $table->string('mess_disc_status')->default(0); // You can specify the appropriate length for 'mess' if it's a string
            $table->decimal('discount', 10, 2)->default(0); // Assuming discount is a decimal with 10 total digits and 2 decimal places
            $table->decimal('total', 10, 2)->default(0); // Assuming total is a decimal with 10 total digits and 2 decimal places
            $table->string('detail')->default('Detail is empty'); // Assuming 'detail' can be a longer text description
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
