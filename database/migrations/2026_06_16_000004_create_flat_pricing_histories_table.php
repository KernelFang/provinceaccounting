<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flat_pricing_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flat_id')->constrained('flats')->cascadeOnDelete();
            $table->decimal('price', 16, 2);
            $table->date('effective_date')->index();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('flat_pricing_histories', function (Blueprint $table) {
            $table->dropForeign(['flat_id']);
            $table->dropForeign(['changed_by']);
        });

        Schema::dropIfExists('flat_pricing_histories');
    }
};
