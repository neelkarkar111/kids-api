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
        Schema::create('mission_completions', function (Blueprint $table) {

            $table->id();
            
            $table->foreignId('mission_id')->constrained('missions')->cascadeOnDelete();
            $table->foreignId('child_id')->constrained('childrens')->cascadeOnDelete();

            $table->timestamp("completed_at");
            $table->timestamps();
            
            $table->unique(['mission_id', 'child_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_completions');
    }
};
