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
		Schema::create('humidity_readings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('device_id');
			$table->integer('humidity');
            $table->timestamp('measured_at')->useCurrent();
            $table->timestamps();

            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->integer('last_humidity')->nullable()->after('sunlight');
            $table->timestamp('last_measured_at')->nullable()->after('last_humidity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn(['last_humidity', 'last_measured_at']);
        });

        Schema::dropIfExists('humidity_readings');
    }
};
