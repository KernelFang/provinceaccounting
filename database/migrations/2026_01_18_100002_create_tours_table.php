<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('purpose');
            $table->string('title')->nullable();
            $table->string('country');
            $table->text('description')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('customer')->nullable();
            $table->integer('person')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('emergency_number')->nullable();
            $table->decimal('agent_cost', 12, 2)->nullable();
            $table->decimal('customer_price', 12, 2)->nullable();
            $table->decimal('customer_payment', 12, 2)->nullable();
            $table->decimal('customer_due', 12, 2)->nullable();
            $table->decimal('profit', 12, 2)->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tours');
    }
};
