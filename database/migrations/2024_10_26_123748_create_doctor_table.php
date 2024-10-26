<?php

use App\Models\Doctor;
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
        Schema::create('doctor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('speciality_id')->nullable()->constrained('specialities')->nullOnDelete()->cascadeOnUpdate();
            $table->string('bio')->nullable();
            $table->string('experience')->nullable();
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->enum('status', [Doctor::ACTIVE, Doctor::INACTIVE])->default(Doctor::INACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor');
    }
};
