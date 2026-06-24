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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->morphs('auditable');  // To track model type and ID (polymorphic)
            $table->string('action');     // 'create', 'update', 'delete', 'login', 'logout'
            $table->json('old_values')->nullable();  // For updates (old data)
            $table->json('new_values')->nullable();  // For updates (new data)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();  // User who performed the action
            $table->string('ip_address')->nullable();  // IP address of the user
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('audits');
    }
};
