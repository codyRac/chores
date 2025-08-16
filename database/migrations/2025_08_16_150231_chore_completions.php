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
        Schema::create('chore_completions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('chore_id')->constrained('chore')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
            $t->unsignedInteger('points_awarded')->default(0);
            $t->timestamp('completed_at');
            $t->timestamps();

            // Prevent duplicate credit for the same chore in the same group by the same user
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chore_completions');

    }
};
