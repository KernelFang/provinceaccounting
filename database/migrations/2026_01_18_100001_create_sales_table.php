<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('issue_date');
            $table->string('issued_portal');
            $table->string('service_type');
            $table->string('gds_pnr')->nullable();
            $table->string('airline_pnr')->nullable();
            $table->decimal('agent_fare', 12, 2)->nullable();
            $table->decimal('customer_fare', 12, 2)->nullable();
            $table->decimal('customer_payment', 12, 2)->nullable();
            $table->decimal('customer_due', 12, 2)->nullable();
            $table->string('segment')->nullable();
            $table->date('last_date_of_payment')->nullable();
            $table->string('airline')->nullable();
            $table->string('flight_type')->nullable();
            $table->string('trip')->nullable();
            $table->string('pax_name')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('tkt_number')->nullable();
            $table->string('passport_nid')->nullable();
            $table->date('flight_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('flight_status')->default('pending');
            $table->decimal('top_balance', 12, 2)->nullable();
            $table->decimal('current_balance', 12, 2)->nullable();
            $table->decimal('agent_price', 12, 2)->nullable();
            $table->decimal('sell_price', 12, 2)->nullable();
            $table->decimal('profit', 12, 2)->nullable();
            $table->decimal('segment_fare', 12, 2)->nullable();
            $table->string('contact_no')->nullable();
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->json('videos')->nullable();
            $table->json('documents')->nullable();
            $table->json('links')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
