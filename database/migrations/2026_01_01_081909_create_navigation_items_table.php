<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('navigation_items', function (Blueprint $table) {
            $table->id();

            // Page reference (label & slug come from Page)
            $table->foreignId('page_id')
                ->constrained()
                ->cascadeOnDelete();

            // Self-referencing hierarchy
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('navigation_items')
                ->cascadeOnDelete();

            // Ordering within the same level
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            // Prevent duplicate pages in the same menu level
            $table->unique(['page_id', 'parent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navigation_items');
    }
};
