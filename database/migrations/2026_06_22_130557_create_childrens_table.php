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
        Schema::create('childrens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedTinyInteger('age');
            $table->string('gender')->nullable();  
            $table->string('parent_pin');
            $table->string('avatar')->nullable();
            $table->unsignedInteger('coins')->default(0);
            $table->unsignedInteger('xp')->default(0);
            $table->unsignedInteger('level')->default(1);
            $table->unsignedTinyInteger('progress')->default(0);
            $table->unsignedInteger('streak')->default(1);
            $table->date('last_active_date')->nullable();
            $table->unsignedInteger('completed_missions')->default(0);
            $table->unsignedInteger('today_screen_time')->default(0); // seconds
            $table->date('screen_time_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('childrens');
    }
};
