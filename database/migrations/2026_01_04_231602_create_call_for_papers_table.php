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
        Schema::create('call_for_papers', function (Blueprint $table) {
            $table->id();
            $table->string('publication_name')->nullable();
            $table->string('journal')->nullable();
            $table->date('publication_date_from')->nullable();
            $table->date('publication_date_to')->nullable();
            $table->date('submission_deadline')->nullable();
            $table->text('information');
            $table->string('information_link')->nullable();
            $table->foreignId('page_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_for_papers');
    }
};
