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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing integer (Primary Key)
            $table->string('name'); // String
            $table->string('phone'); // Provide an empty string as the default value
            $table->string('email')->unique(); // String (Unique)
            $table->timestamp('email_verified_at')->nullable();// Timestamp (Nullable)
            $table->string('password'); // String (Assuming it will be hashed)
            $table->string('address'); // String
            $table->date('date_of_birth')->nullable(); // Date
            $table->string('cnic'); // String
            $table->string('role'); // String
            $table->decimal('percentage')->default(0); // Decimal (5 digits in total, 2 decimal places)
            $table->string('status'); // Enum (Choose appropriate status values)
            $table->rememberToken(); // String
            $table->timestamps(); // Created at and Updated at timestamps
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
