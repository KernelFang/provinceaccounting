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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->foreignId('expense_type_id')->constrained('expense_types')->cascadeOnDelete();
            $table->foreignId('flat_id')->nullable()->constrained('flats')->nullOnDelete();
            $table->foreignId('payment_method_id')->constrained('payment_methods')->cascadeOnDelete();
            $table->date('date')->index();
            $table->text('expense_details')->nullable();
            $table->decimal('amount', 18, 2);
            $table->string('transaction_reference', 191)->index();
            $table->enum('payment_status', ['paid', 'unpaid', 'petty_cash'])->default('paid');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'expense_type_id', 'date']);
            $table->index(['payment_method_id', 'amount']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['expense_type_id']);
        });

        Schema::dropIfExists('expenses');
    }
};
