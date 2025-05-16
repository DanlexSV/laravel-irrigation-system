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
		Schema::table('devices', function (Blueprint $table) {
            $table->unsignedBigInteger('floor_id')->nullable()->after('user_id');
            $table->integer('water_frequency')->nullable()->after('floor_id');
            $table->string('sunlight')->nullable()->after('water_frequency');

            $table->foreign('floor_id')->references('id')->on('floors')->onDelete('set null');
        });

		Schema::dropIfExists('user_floors');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		Schema::table('devices', function (Blueprint $table) {
            $table->dropForeign(['floor_id']);
            $table->dropColumn(['floor_id', 'water_frequency', 'sunlight']);
        });

		Schema::create('user_floors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('floor_id');
            $table->integer('water_frequency')->nullable();
            $table->string('sunlight')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('floor_id')->references('id')->on('floors')->onDelete('cascade');
        });
    }
};
