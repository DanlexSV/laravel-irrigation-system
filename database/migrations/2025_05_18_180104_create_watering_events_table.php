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
        Schema::create('watering_events', function (Blueprint $table) {
            $table->id();
			$table->foreignId('device_id')->constrained()->onDelete('cascade');
            $table->timestamp('watered_at')->default(now());
            $table->unsignedInteger('duration_seconds');
            $table->string('source')->default('auto');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watering_events');
    }
};
