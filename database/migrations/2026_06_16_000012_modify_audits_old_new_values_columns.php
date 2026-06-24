<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to avoid requiring doctrine/dbal for column type changes
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `audits` MODIFY `old_values` LONGTEXT NULL');
            DB::statement('ALTER TABLE `audits` MODIFY `new_values` LONGTEXT NULL');
        } elseif ($driver === 'sqlite') {
            // SQLite: recreate table is required; skip in tests where schema is rebuilt often
        } else {
            // For other drivers, attempt a generic change using schema builder (may require doctrine/dbal)
            try {
                \Illuminate\Support\Facades\Schema::table('audits', function ($table) {
                    $table->text('old_values')->nullable()->change();
                    $table->text('new_values')->nullable()->change();
                });
            } catch (\Throwable $e) {
                // If it fails, surface a helpful error
                throw $e;
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `audits` MODIFY `old_values` JSON NULL');
            DB::statement('ALTER TABLE `audits` MODIFY `new_values` JSON NULL');
        } elseif ($driver === 'sqlite') {
            // No-op
        } else {
            try {
                \Illuminate\Support\Facades\Schema::table('audits', function ($table) {
                    $table->json('old_values')->nullable()->change();
                    $table->json('new_values')->nullable()->change();
                });
            } catch (\Throwable $e) {
                throw $e;
            }
        }
    }
};
