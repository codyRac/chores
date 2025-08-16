<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Group;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Group::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();

            // optional pivot data
            $table->string('role')->nullable();     // e.g. owner, admin, member
            $table->timestamp('joined_at')->nullable();
            $table->integer('points')->default(0);
            $table->integer('earned')->default(0);
            $table->integer('redeemed')->default(0);

            $table->timestamps();

            // prevent duplicates of same (group_id, user_id)
            $table->unique(['group_id', 'user_id']);
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_user');
    }
};
