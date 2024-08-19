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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
        $table->string('brand');
        $table->string('model');
        $table->string('plate_number')->unique();
        $table->decimal('rental_rate', 8, 2);
        $table->boolean('available')->default(true);
        $table->string('photo')->nullable(); // Tambahkan kolom untuk foto
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
