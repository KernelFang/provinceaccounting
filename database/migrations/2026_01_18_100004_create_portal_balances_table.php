<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('portal_balances', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type')->nullable();
            $table->string('info');
            $table->date('date')->nullable();
            $table->string('portal');
            $table->decimal('recharge', 12, 2)->nullable();
            $table->string('sender')->nullable();
            $table->string('reference')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('portal_balances');
    }
};
