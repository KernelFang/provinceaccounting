<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('training_type')->nullable();
            $table->string('title')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_number')->nullable();
            $table->string('package')->nullable();
            $table->text('description')->nullable();
            $table->decimal('agent_cost', 12, 2)->nullable();
            $table->decimal('customer_price', 12, 2)->nullable();
            $table->decimal('customer_payment', 12, 2)->nullable();
            $table->decimal('customer_due', 12, 2)->nullable();
            $table->decimal('profit', 12, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainings');
    }
};
