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
        if (!Schema::hasTable('group_join_requests')) {
            Schema::create('group_join_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
                $table->timestamps();
                $table->unique(['group_id', 'user_id']);
            });
        } else {
            // Table exists, add columns if missing
            Schema::table('group_join_requests', function (Blueprint $table) {
                if (!Schema::hasColumn('group_join_requests', 'group_id')) {
                    $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
                }
                if (!Schema::hasColumn('group_join_requests', 'user_id')) {
                    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('group_join_requests', 'status')) {
                    $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_join_requests');
    }
};
