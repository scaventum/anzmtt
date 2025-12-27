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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('email');
            $table->string('last_name')->nullable();
            $table->string('title')->nullable();
            $table->string('role')->nullable();
            $table->string('organisation')->nullable();
            $table->json('types')->nullable();
            $table->json('interests')->nullable();
            $table->text('bio')->nullable();
            $table->timestamp('last_active_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
