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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id'); // Assuming this is a foreign key to a 'tenants' table
            $table->unsignedBigInteger('booking_id'); // Assuming this is a foreign key to a 'bookings' table
            $table->string('status');
            $table->string('payment_method');
            $table->decimal('agent_commission', 10, 2); // Use decimal for monetary values
            $table->string('mess');
            $table->string('mess_disc');
            $table->decimal('rent', 10, 2); // Use decimal for monetary values
            $table->decimal('discount', 10, 2); // Use decimal for monetary values
            $table->decimal('total_amount', 10, 2); // Use decimal for monetary values
            $table->decimal('paid_amount', 10, 2); // Use decimal for monetary values
            $table->decimal('balance_amount', 10, 2); // Use decimal for monetary values
            $table->date('balance_due_date'); // Assuming this is a date
            $table->date('next_due_date'); // Assuming this is a date
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
