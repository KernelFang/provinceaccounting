<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('building_no', 50)->nullable();
            $table->string('floor_no', 50)->nullable();
            $table->string('flat_no', 50)->nullable();
            $table->decimal('total_flat_area_sqft', 12, 2)->nullable();
            $table->decimal('cost_per_sqft', 16, 2)->nullable();
            $table->decimal('base_price', 18, 2)->nullable();
            $table->boolean('is_reselled')->default(false);
            $table->enum('client_owner_status', ['pending', 'ongoing', 'cancelled', 'completed'])->index();
            $table->foreignId('current_owner_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'client_owner_status']);
        });
    }

    public function down(): void
    {
        Schema::table('flats', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['current_owner_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);
        });

        Schema::dropIfExists('flats');
    }
};
