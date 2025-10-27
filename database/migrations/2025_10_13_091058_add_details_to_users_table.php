<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('village')->nullable();
            $table->string('post')->nullable();
            $table->string('police_station')->nullable();
            $table->string('district')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['dob', 'phone', 'village', 'post', 'police_station', 'district']);
        });
    }
};